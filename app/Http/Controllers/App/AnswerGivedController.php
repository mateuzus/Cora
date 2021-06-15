<?php

namespace App\Http\Controllers\App;

use App\Entities\AnswerGiven;
use App\Entities\FlowRules;
use App\Entities\FontDataDetail;
use App\Entities\Listing;
use App\Entities\PossibleAnswer;
use App\Entities\Question;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnswerGivedController extends Controller
{
    public function store($questionId,Request $request){
        $question  = Question::find($questionId);
        $rule = $question->rule;
        $nextRule = FlowRules::where('flow_id',$rule->flow->id)
            ->where('order','>' ,$rule->order)
            ->first();


        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";
            $path = 'storage/img/'.$questionId."/".$nameFile;
            $upload = $request->photo->storeAs('public/img/'.$questionId, $nameFile);

            $data = [
                'question_id'=>$questionId,
//                'response'=>json_encode([$path]),
                'response_content' =>$path,
                'type'=>'photo',

            ];

        }else{


            $data = [
                'question_id'=>$questionId,
                //'response'=>json_encode([$request->answer]),
                'response_content'=>$request->answer,
                'type'=>$question->question_type,
            ];
        }



        $answerGiven = AnswerGiven::create($data);
        $answerGiven = AnswerGiven::find($answerGiven->id);

        $question->status = true;
        $question->save();


        //faz o encadeamento da pergunta
        //tem nextrule?
        if($nextRule){
            $answer = $answerGiven->answer;



            $triggerRule = $rule->trigger;
            $triggerRuleRule = $rule->trigger_rule;



            // a condição de encadeamento da regra foi atendida?
            $canNextRole = false;
            switch ($rule->question_type){
                case "number_decimal" || 'number_integer':
                    if($rule->use_network_config){
                        $percentual = $rule->flow->network->config->price_lowering_rules;
                        $ref = $question->value;
                        $canNextRole = $this->calculeIfCanNextRole($triggerRuleRule, $answer, $ref, $percentual);
                    }else{
                        $ref = $question->value;
                        $canNextRole = $this->calculeIfCanNextRole($triggerRuleRule, $answer, $ref);
                    }

                    break;

                case "boolean":
                    $canNextRole = $this->calculeIfCanNextRole($triggerRuleRule, $answer, "SIM");
                    break;
                default:
                    break;
            }


            //PODE IR PARA O PROXIMO PASSO
            if($canNextRole){


                $nextList = $this->getNextList($nextRule, $question->listing);

                $this->createQuestion($nextList, $nextRule, $question);
            }
        }


        return response()->json(['data'=>$answerGiven, 'message'=>"Resposta adicionada com sucesso"])->setEncodingOptions(JSON_NUMERIC_CHECK);

    }
    private function calculeIfCanNextRole($triggerRuleRule, $answer, $ref, $percentual = null){
        $can = false;
        if($percentual){
            // 10
            $refMax  = $ref * (1+($percentual/100));
            $refMin  = $ref * (1-($percentual/100));

            $can = ($answer >= $refMax) || ($answer || $refMin);
        }else{
            switch ( $triggerRuleRule){
                case ">":
                    $can= $answer > $ref;
                    break;
                case ">=":
                    $can= $answer >= $ref;
                    break;
                case "<=":
                    $can= $answer <= $ref;
                    break;
                case "<":
                    $can= $answer < $ref;
                    break;
                case "=":
                    $can= $answer = $ref;
                    break;
                case "!=":
                    $can= $answer != $ref;
                    break;
            }
        }


        return $can;

    }

    private function getNextList($nextRule, $oldList)
    {

        $network = $nextRule->flow->network_id;
        $store = $nextRule->store_id;
        $department = $nextRule->department_id;
        $role = $nextRule->role_id;
        $team = $nextRule->team_id;
        $flow = $nextRule->flow_id;
        $rule = $nextRule->id;
        $user = $this->getListUsers($network, $store, $role, $department, $team);
        if(!$user){
            return false;
        }
        $list = Listing::today()
            ->where("user_id", $user->id)
            ->where('network_id', $network)
            ->where('store_id', $store)
            ->where('store_id', $department)
            ->where('team_id', $team)
            ->where('flow_id', $flow)
            ->where('flow_rule_id', $rule)
            ->first();

        if(!$list){

            $storeName = $nextRule->store->name;
            $departmentName = $nextRule->department->name;
            $teamName = $nextRule->team->name;

            if($oldList->type == 'pops'){

                $description =  "#POP ".$oldList->pop->code." - ".$storeName." - ".$departmentName." - ".$teamName;
            }else{
                $description = $oldList->pop->code." - ".$storeName." - ".$departmentName." - ".$teamName;
            }


            $list = Listing::create([
                'user_id'=>$user->id,
                'network_id'=>$network,
                'store_id'=>$store,
                'department_id'=>$department,
                'team_id'=>$team,
                'flow_id'=>$flow,
                'flow_rule_id'=>$nextRule->id,
                'pop_id'=>$oldList->pop_id ?? null,
                'routine_id'=>$oldList->routine_id ?? null,
                'description'=>$description,
                'creation_date'=>Carbon::now(),
                'type'=>$oldList->type,
                'status'=>0,
                'list_tag'=>$department,
                'period_start' => Carbon::now(),
                'period_end' => $oldList->pop->getEndDate(),
            ]);
        }
        return $list;
    }

    private function createQuestion($nextList, $nextRule, $oldQuestion)
    {
        $dataQuestion = [
            'list_id' => $nextList->id,
            'rule_id'=>$nextRule->id,
            'description' => $nextRule->name . " - " . $oldQuestion->description,
            'question_type' => $nextRule->question_type,
            'quantity' =>  $oldQuestion->value,
            'status' => 0,
        ];



        $question = Question::updateOrCreate(
            [
                'list_id' => $nextList->id,
                'description' => $dataQuestion['description'],
            ],
            $dataQuestion
        );
        if($question->question_type ==  "boolean"){
            $possibleAnswer = PossibleAnswer::updateOrCreate(
                [
                    'question_id'=>$question->id,
                    'description'=>"SIM",
                    'value'=>"SIM",
                ],
                [
                    'question_id'=>$question->id,
                    'description'=>"SIM",
                    'value'=>"SIM",
                ]
            );
            $possibleAnswer = PossibleAnswer::updateOrCreate(
                [
                    'question_id'=>$question->id,
                    'description'=>"NÃO",
                    'value'=>"NAO",
                ],
                [
                    'question_id'=>$question->id,
                    'description'=>"NÃO",
                    'value'=>"NAO",
                ]
            );
        }
    }
    private function getListUsers($network, $stores, $roles, $departments, $teams)
    {

        $users = User::whereHas("networks", function ($query) use ($network) {
            return $query->where("networks.id", $network);
        })
            ->whereHas("roles", function ($query) use ($roles) {
                return $query->where("roles.id", $roles);
            })
            ->whereHas("stores", function ($query) use ($stores) {
                return $query->where("stores.id", $stores);
            })
            ->whereHas("departments", function ($query) use ($departments) {
                return $query->where("departments.id", $departments);
            })
            ->whereHas("teams", function ($query) use ($teams) {
                return $query->where("teams.id", $teams);
            })
            ->first();

        return $users;
    }
}
