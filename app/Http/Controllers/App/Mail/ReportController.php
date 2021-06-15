<?php

namespace App\Http\Controllers\App\Mail;

use App\Entities\Network;
use App\Entities\Role;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Notifications\ListDaily;
use App\Notifications\ReportEndDay;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * ReportController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getReportQuestionsToday(){
        $netWork = Network::active()->first();
        $usersOperators = $this->user->usersOperatorNetWork($netWork);
        $userAdmins =  $this->user->usersAdminNetWork($netWork)->first();
        $questionsArray = [
            'total'=>0,
            'answers' =>0,
        ];
        foreach ($usersOperators as $user){
            $reportQuestionsToday = $user->reportQuestionsToday();
            //total e answers
            $questionsArray['total'] += $reportQuestionsToday['total'];
            $questionsArray['answers'] += $reportQuestionsToday['answers'];
        }
        $questionsArray['effectiveness'] = $questionsArray['answers']/$questionsArray['total'];
        return (new ListDaily($questionsArray))
            ->toMail($userAdmins);
    }
    public function getReportQuestionsEndDay(){
        $netWork = Network::active()->first();
        $usersOperators = $this->user->usersOperatorNetWork($netWork);
        $userAdmins =  $this->user->usersAdminNetWork($netWork)->first();

        //perguntas dessa rede
        $questionsByRoles  = collect([]);
        foreach ($usersOperators as $usersOperator){
            $questionsByRoles->add($usersOperator->reportQuestionsByRoles());
        }



        return (new ReportEndDay($questionsByRoles))
            ->toMail($userAdmins);
    }
    public function syncRoles(){
        $roles = [
            "SUPER_ADMIN",
            "REDE_API",
            "REDE_ADMIN",
            "KIKKER_API",
            "LOJA_GERENTE",
            "LOJA_OPERADOR",
            "LOJA_PRESENCA_GONDOLA",
            "LOJA_INVENTARIO",
            "LOJA_COMPRADOR",
            "LOJA_REPOSITOR",
            "LOJA_GERENTE_DEPARTAMENTO",
            "LOJA_MARKETING",
            "AUDITORIA",
        ];

        foreach ($roles as $role){
            Role::updateOrCreate(
                ['name' => $role],
                ['name' => $role]
            );
        }
        return response()->json("Atualizadas");
    }
    public function getQuestionsByRole(){
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
        $netWork = Network::active()->first();
        $userAdmins =  $this->user->usersAdminNetWork($netWork)->first();
        $usersOperators = $this->user->usersOperatorNetWork($netWork);

        $questionsByRole = collect([]);
        foreach ($roles as $role){
            $getQuestionsByRole = $this->user->getQuestionsByRole($role, $netWork);
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
        return (new ReportEndDay($questionsByRole, $questionByUsers))
            ->toMail($userAdmins);

    }


}
