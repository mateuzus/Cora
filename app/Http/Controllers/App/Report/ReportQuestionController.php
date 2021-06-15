<?php

namespace App\Http\Controllers\App\Report;

use App\Entities\Network;
use App\Entities\Role;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Notifications\ReportEndDay;
use Illuminate\Http\Request;

class ReportQuestionController extends Controller
{
    public function show($user_id){

        $user = User::find($user_id);
        $netWork = $user->networks->first();
        if(!$user){
            return abort(400, "PARAMETROS NÃO ENCONTRADOS");
        }
        if(!$netWork){
            return abort(400, "PARAMETROS NÃO ENCONTRADOS");
        }
        if(!$user->isAdminRede()){
            return abort(403, "NÃO AUTORIZADO");
        }

        $roles = Role::whereIn('name',[
            "LOJA_OPERADOR",
            "LOJA_GERENTE",
            "LOJA_PRESENCA_GONDOLA",
            "LOJA_INVENTARIO",
            "LOJA_COMPRADOR",
            "LOJA_REPOSITOR",
            "LOJA_GERENTE_DEPARTAMENTO",
            "LOJA_MARKETING",
            "AUDITORIA",
        ])->get();
        $usersOperators = $user->usersOperatorNetWork($netWork);

        $questionsByRole = collect([]);
        foreach ($roles as $role){
            $getQuestionsByRole = $user->getQuestionsByRole($role, $netWork);
            $getQuestionsByRole['role']=$role;
            if($getQuestionsByRole['qtdQuestions'] == 0){
                $getQuestionsByRole['effectiveness'] = 0;
            }else{
                $getQuestionsByRole['effectiveness'] = number_format($getQuestionsByRole['qtdQuestionsAnswers']/$getQuestionsByRole['qtdQuestions'], 1);
            }
            $questionsByRole->add($getQuestionsByRole);
        }
        $questionByUsers  = collect([]);
        foreach ($usersOperators as $usersOperator){
            $getQuestionsByUser = $usersOperator->reportQuestions();
            if($getQuestionsByUser['qtdQuestions'] == 0){
                $getQuestionsByUser['effectiveness'] = 0;
            }else{
                $getQuestionsByUser['effectiveness'] = number_format($getQuestionsByUser['qtdQuestionsAnswers']/$getQuestionsByUser['qtdQuestions'], 1);
            }
            $questionByUsers->add($getQuestionsByUser);
        }


        return response()->json(['questionsByRole'=>$questionsByRole, 'questionByUsers'=>$questionByUsers]);
    }
}
