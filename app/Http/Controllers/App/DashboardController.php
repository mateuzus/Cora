<?php

namespace App\Http\Controllers\App;

use App\Entities\Listing;
use App\Entities\Question;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request){

        if($request->user_id){
            $user = User::find($request->user_id);
        }else{
            $user = $request->user('api');
        }

        $networks = collect([]);
        foreach ($user->networks as $net){
            $networks->push($net->id);
        }
        $lists  = Listing::whereIn('network_id',$networks )->today()->get();
        $finalized = $lists->where('status', '2')->count();
        $notStarted = $lists->where('status', '0')->count();
        $initiated = $lists->where('status', '1')->count();
        $finalizedNot = $lists->where('status', '3')->count();
        $totalLists = $lists->count();
        $unfinished = $lists->where('status', '0')->count();

        $userToNetwork = $lists->groupBy("user_id")->count();
        $userToNetworkAnswered = $lists->where('status', '2')->groupBy("user_id")->count();
        $userToNetworkFinalized = $userToNetwork - $userToNetworkAnswered;

        $groupListingPerRole = Listing::selectRaw("
                roles.name,
                count(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->whereIn('network_id',$networks)
            ->today()
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();
        $groupQuestionsPerRole = Question::selectRaw("
                roles.name,
                COUNT(questions.id) AS qtd_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '0') AS qtd_unanswered_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '1') AS qtd_answered_questions
            ")
            ->whereIn('network_id',$networks)
            ->join('lists', 'lists.id', '=','questions.list_id')
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();


        $totalQuestions = Question::whereIn("list_id", $lists->pluck('id'))->get();
        $totalQuestionsAnswered = $totalQuestions->where('status',1);
        $totalUnansweredQuestions = $totalQuestions->where('status',0);



        $initiated7Days = Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(7)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $initiated90Days =  Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(90)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $users = User::with('listings')->usersNetWork($networks)->get();
        $topUsers = collect([]);
        foreach ($users as $user){
            $listings = $user->listingNow;


            $topUsers->push([
                'name'=>$user->name,
                'qtd_lists'=>$listings->count(),
                'qtd_unanswered_list'=>$listings->where("status", 0)->count(),
                'qtd_answered_list'=>$listings->where("status", 2)->count(),
                'qtd_not_finalized'=>$listings->where("status", 3)->count(),
                'effectives_seven_day'=>$user->effectivenessSevenDays(),
                'effectives_nineteen_day'=>$user->effectivenessNinetenDays(),
            ]);
        }

        $data = [
            'lists' => ['not_started' => $notStarted, 'initiates' => $initiated, 'finished' => $finalized,
            'finalized_but_not_complete' => $finalizedNot, 'not_finalized' => $unfinished, 'total' => $totalLists],
            'operators' => [
                'total_of_users' => $userToNetwork,
                'users_who_didnt_responded' => $userToNetworkFinalized,
                'users_who_responded' => $userToNetworkAnswered
            ],
            'questions'=>[
                'total_unanswered_questions'=>$totalUnansweredQuestions->count(),
                'total_questions_answered'=>$totalQuestionsAnswered->count(),
                'total_questions'=>$totalQuestions->count(),
            ],
            'total_per_user' => [
                'listings' => $groupListingPerRole->map->only('name','qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
                'questions' => $groupQuestionsPerRole->map->only('name','qtd_questions', 'qtd_unanswered_questions', 'qtd_answered_questions')
            ],
            'total_per_user_last_7_days' => $initiated7Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'total_per_user_last_90_days' => $initiated90Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'top_users'=>$topUsers,
        ];

        return response()->json($data);
    }
    public function dashboardByUser(Request $request){

        if($request->user_id){
            $user = User::find($request->user_id);
        }else{
            $user = $request->user('api');
        }

        $networks = collect([]);
        foreach ($user->networks as $net){
            $networks->push($net->id);
        }
        $lists  = Listing::whereIn('network_id',$networks )->today()->get();
        $finalized = $lists->where('status', '2')->count();
        $notStarted = $lists->where('status', '0')->count();
        $initiated = $lists->where('status', '1')->count();
        $finalizedNot = $lists->where('status', '3')->count();
        $totalLists = $lists->count();
        $unfinished = $lists->where('status', '0')->count();

        $userToNetwork = $lists->groupBy("user_id")->count();
        $userToNetworkAnswered = $lists->where('status', '2')->groupBy("user_id")->count();
        $userToNetworkFinalized = $userToNetwork - $userToNetworkAnswered;

        $groupListingPerRole = Listing::selectRaw("
                roles.name,
                count(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->whereIn('network_id',$networks)
            ->today()
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();
        $groupQuestionsPerRole = Question::selectRaw("
                roles.name,
                COUNT(questions.id) AS qtd_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '0') AS qtd_unanswered_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '1') AS qtd_answered_questions
            ")
            ->whereIn('network_id',$networks)
            ->join('lists', 'lists.id', '=','questions.list_id')
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();


        $totalQuestions = Question::whereIn("list_id", $lists->pluck('id'))->get();
        $totalQuestionsAnswered = $totalQuestions->where('status',1);
        $totalUnansweredQuestions = $totalQuestions->where('status',0);



        $initiated7Days = Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(7)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $initiated90Days =  Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(90)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $users = User::with('listings')->usersNetWork($networks)->get();
        $topUsers = collect([]);
        foreach ($users as $user){
            $listings = $user->listingNow;


            $topUsers->push([
                'name'=>$user->name,
                'qtd_lists'=>$listings->count(),
                'qtd_unanswered_list'=>$listings->where("status", 0)->count(),
                'qtd_answered_list'=>$listings->where("status", 2)->count(),
                'qtd_not_finalized'=>$listings->where("status", 3)->count(),
                'effectives_seven_day'=>$user->effectivenessSevenDays(),
                'effectives_nineteen_day'=>$user->effectivenessNinetenDays(),
            ]);
        }

        $data = [
            'lists' => ['not_started' => $notStarted, 'initiates' => $initiated, 'finished' => $finalized,
            'finalized_but_not_complete' => $finalizedNot, 'not_finalized' => $unfinished, 'total' => $totalLists],
            'operators' => [
                'total_of_users' => $userToNetwork,
                'users_who_didnt_responded' => $userToNetworkFinalized,
                'users_who_responded' => $userToNetworkAnswered
            ],
            'questions'=>[
                'total_unanswered_questions'=>$totalUnansweredQuestions->count(),
                'total_questions_answered'=>$totalQuestionsAnswered->count(),
                'total_questions'=>$totalQuestions->count(),
            ],
            'total_per_user' => [
                'listings' => $groupListingPerRole->map->only('name','qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
                'questions' => $groupQuestionsPerRole->map->only('name','qtd_questions', 'qtd_unanswered_questions', 'qtd_answered_questions')
            ],
            'total_per_user_last_7_days' => $initiated7Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'total_per_user_last_90_days' => $initiated90Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'top_users'=>$topUsers,
        ];

        return response()->json($data);
    }
    public function dashboardByManager(Request $request){

        if($request->user_id){
            $user = User::find($request->user_id);
        }else{
            $user = $request->user('api');
        }

        $networks = collect([]);
        foreach ($user->networks as $net){
            $networks->push($net->id);
        }
        $lists  = Listing::whereIn('network_id',$networks )->today()->get();
        $finalized = $lists->where('status', '2')->count();
        $notStarted = $lists->where('status', '0')->count();
        $initiated = $lists->where('status', '1')->count();
        $finalizedNot = $lists->where('status', '3')->count();
        $totalLists = $lists->count();
        $unfinished = $lists->where('status', '0')->count();

        $userToNetwork = $lists->groupBy("user_id")->count();
        $userToNetworkAnswered = $lists->where('status', '2')->groupBy("user_id")->count();
        $userToNetworkFinalized = $userToNetwork - $userToNetworkAnswered;

        $groupListingPerRole = Listing::selectRaw("
                roles.name,
                count(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->whereIn('network_id',$networks)
            ->today()
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();
        $groupQuestionsPerRole = Question::selectRaw("
                roles.name,
                COUNT(questions.id) AS qtd_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '0') AS qtd_unanswered_questions,
                COUNT(questions.id) FILTER (WHERE questions.status = '1') AS qtd_answered_questions
            ")
            ->whereIn('network_id',$networks)
            ->join('lists', 'lists.id', '=','questions.list_id')
            ->join('users', 'users.id', '=','lists.user_id')
            ->join('user_roles', 'users.id', '=','user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=','roles.id')
            ->groupBy('roles.name')
            ->get();


        $totalQuestions = Question::whereIn("list_id", $lists->pluck('id'))->get();
        $totalQuestionsAnswered = $totalQuestions->where('status',1);
        $totalUnansweredQuestions = $totalQuestions->where('status',0);



        $initiated7Days = Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(7)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $initiated90Days =  Listing::selectRaw("
                TO_CHAR(creation_date, 'DD/MM') as date,
                COUNT(*) AS qtd_list,
                COUNT(*) FILTER (WHERE lists.status = '0') AS qtd_unanswered_list,
                COUNT(*) FILTER (WHERE lists.status = '2') AS qtd_answered_list
            ")
            ->byDate(90)
            ->whereIn('network_id',$networks)
            ->groupBy(DB::raw("TO_CHAR(creation_date, 'DD/MM')"))
            ->get();
        $users = User::with('listings')->usersNetWork($networks)->get();
        $topUsers = collect([]);
        foreach ($users as $user){
            $listings = $user->listingNow;


            $topUsers->push([
                'name'=>$user->name,
                'qtd_lists'=>$listings->count(),
                'qtd_unanswered_list'=>$listings->where("status", 0)->count(),
                'qtd_answered_list'=>$listings->where("status", 2)->count(),
                'qtd_not_finalized'=>$listings->where("status", 3)->count(),
                'effectives_seven_day'=>$user->effectivenessSevenDays(),
                'effectives_nineteen_day'=>$user->effectivenessNinetenDays(),
            ]);
        }

        $data = [
            'lists' => ['not_started' => $notStarted, 'initiates' => $initiated, 'finished' => $finalized,
            'finalized_but_not_complete' => $finalizedNot, 'not_finalized' => $unfinished, 'total' => $totalLists],
            'operators' => [
                'total_of_users' => $userToNetwork,
                'users_who_didnt_responded' => $userToNetworkFinalized,
                'users_who_responded' => $userToNetworkAnswered
            ],
            'questions'=>[
                'total_unanswered_questions'=>$totalUnansweredQuestions->count(),
                'total_questions_answered'=>$totalQuestionsAnswered->count(),
                'total_questions'=>$totalQuestions->count(),
            ],
            'total_per_user' => [
                'listings' => $groupListingPerRole->map->only('name','qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
                'questions' => $groupQuestionsPerRole->map->only('name','qtd_questions', 'qtd_unanswered_questions', 'qtd_answered_questions')
            ],
            'total_per_user_last_7_days' => $initiated7Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'total_per_user_last_90_days' => $initiated90Days->map->only('date', 'qtd_list', 'qtd_unanswered_list', 'qtd_answered_list'),
            'top_users'=>$topUsers,
        ];

        return response()->json($data);
    }

}
