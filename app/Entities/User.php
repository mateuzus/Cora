<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];



    public function hasPermission($permission)
    {
        $hasPermission = false;
        foreach ($this->roles as $role){
            if(!$role->permissions->whereIn('id',$permission->id)->isEmpty()){
                $hasPermission = true;
            }
        }
        return $hasPermission;
    }
    public function isSuperAdmin()
    {
        return $this->roles->first()->slug == "admin" ? true : false;
    }

    public function isManagerNetwork(){
        return $this->roles()->first()? $this->roles()->first()->slug=='manager'? true:false:false;
    }



    public function stores(){
        return $this->belongsToMany(Store::class, "user_stores", "user_id", 'store_id');
    }
    public function roles(){
        return $this->belongsToMany(Role::class, "user_roles", "user_id", 'role_id');
    }
    public function teams(){
        return $this->belongsToMany(Team::class, "user_teams", "user_id", 'team_id');
    }
    public function departments(){
        return $this->belongsToMany(Department::class, "user_departments", "user_id", 'department_id');
    }
    public function networks(){
        return $this->belongsToMany(Network::class, "user_networks");
    }


    public function listings(){
        return $this->hasMany(Listing::class, 'user_id' );
    }
    public function listingNow(){
        return $this->hasMany(Listing::class, 'user_id' )
            ->today();
    }
    public function effectivenessSevenDays(){
        $effectiveness = Listing::where("user_id", $this->id)
            ->byDate(7)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = '0')  as answered
            ")
            ->first();
        if($effectiveness->total ==0){
            return 0;
        }
        return number_format(($effectiveness->answered / $effectiveness->total)* 100, 1, ',','.');
    }
    public function effectivenessNinetenDays(){


        $effectiveness = Listing::where("user_id", $this->id)
            ->byDate(90)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = '0')  as answered
            ")
            ->first();
        if($effectiveness->total ==0){
            return 0;
        }
        return number_format(($effectiveness->answered / $effectiveness->total)* 100, 1,',','.');
    }


    public function scopeActive($query){
        return $query->where("status", 1);
    }
    public function scopeUsersNetWork($query, $netWork){
        return $query
            ->whereHas('networks', function ($query) use ($netWork){
                return $query->where('networks.id', $netWork);
            });
    }
    public function scopeWithoutAdmin($query){
        return  $query->whereHas('roles', function ($query){
                return $query->where('slug','!=', 'admin');
            });
    }
    public function getQuestionsToday(){
         $listing = Listing::listingOperator($this->operator)
            ->listingToday()
            ->pluck('id');

        return $questions = Question::joinLists($listing)->get();
    }
    public function reportQuestionsToday(){
        $questionArray = [
            'total'=>0,
            'answers' =>0,
        ];
        $questions = $this->getQuestionsToday();

        if($questions->count() > 0){
            $questionArray['total'] = $questions->count();
            $questionArray['answers'] = $questions->where('status', 'RESPONDIDA')->count();
        }

        return $questionArray;

    }
    public function reportListingToday(){
        $listingArray = [
            'total'=>0,
            'open' =>0,
            'finalized' =>0,
            'close' =>0
        ];
        $listing = Listing::listingOperator($this->operator)
            ->listingToday()
            ->get();
        if($listing->count() > 0){
            $listing_open = clone ($listing);
            $listing_finalized = clone ($listing);
            $listing_close = clone ($listing);

            $listing_open = $listing_open->where("status", 'ATIVA');
            $listing_finalized = $listing_finalized->where("status", 'FINALIZADA');
            $listing_close = $listing_close->where("status", 'ENCERRADA');

            $listingArray['total'] = $listing->count();
            $listingArray['open'] = $listing_open->count();
            $listingArray['finalized'] = $listing_finalized->count();
            $listingArray['close'] = $listing_close->count();

        }

        return $listingArray;

    }
    public function reportQuestions(){
        $listing = Listing::listingOperator($this->operator)
            ->listingToday()
            ->pluck('id');

        $questions = Question::joinLists($listing)->get();

        $qtdQuestions = $questions->count();
        $qtdQuestionsAnswers = Question::joinLists($listing)->has('answersGiven')->count();
        $qtdQuestionsAnswersYes = Question::joinLists($listing)->whereHas('answersGiven', function ($query){
            $query->where('json_line', '["SIM"]');
        })->count();
        $qtdQuestionsAnswersNo = Question::joinLists($listing)->whereHas('answersGiven', function ($query){
            $query->where('json_line', '["NAO"]');
        })->count();
       return
            [
                'usersOperator'=>$this->operator,
                'qtdQuestions'=>$qtdQuestions,
                'qtdQuestionsAnswers'=>$qtdQuestionsAnswers,
                'qtdQuestionsAnswersYes'=>$qtdQuestionsAnswersYes,
                'qtdQuestionsAnswersNo'=>$qtdQuestionsAnswersNo,
            ];
    }

    public function getUsersByRole(Role $role, Network $netWork){

        return $this->whereHas('operator', function ($query){
            return $query->where("id", '!=', null);
        })
            ->whereHas('network', function ($query) use ($netWork){
                return $query->where('id', $netWork->id);
            })
            ->whereHas('role', function ($query) use ($role){
                return $query->where('id', $role->id);
            })
            ->get();
    }

    public function getQuestionsByRole(Role $role,  Network $netWork){
        $users = $this->getUsersByRole($role, $netWork);

        $rolesColletion = [
            'qtdQuestions'=>0,
            'qtdQuestionsAnswers'=>0,
            'qtdQuestionsAnswersYes'=>0,
            'qtdQuestionsAnswersNo'=>0,
        ];
        foreach ($users as $user){
            $listing = Listing::listingOperator($user->operator)
                ->listingToday()
                ->pluck('id');

            $questions = Question::joinLists($listing)->get();

            $qtdQuestions = $questions->count();
            $qtdQuestionsAnswers = Question::joinLists($listing)->has('answersGiven')->count();
            $qtdQuestionsAnswersYes = Question::joinLists($listing)->whereHas('answersGiven', function ($query){
                $query->where('json_line', '["SIM"]');
            })->count();
            $qtdQuestionsAnswersNo = Question::joinLists($listing)->whereHas('answersGiven', function ($query){
                $query->where('json_line', '["NAO"]');
            })->count();

            $rolesColletion['qtdQuestions'] += $qtdQuestions;
            $rolesColletion['qtdQuestionsAnswers'] += $qtdQuestionsAnswers;
            $rolesColletion['qtdQuestionsAnswersYes'] += $qtdQuestionsAnswersYes;
            $rolesColletion['qtdQuestionsAnswersNo'] += $qtdQuestionsAnswersNo;

        }
        return collect($rolesColletion);


    }

}
