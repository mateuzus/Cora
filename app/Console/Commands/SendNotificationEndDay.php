<?php

namespace App\Console\Commands;

use App\Entities\Listing;
use App\Entities\Network;
use App\Entities\Question;
use App\Entities\Role;
use App\Entities\User;
use App\Notifications\ListDaily;
use App\Notifications\ReportEndDay;
use Illuminate\Console\Command;

class SendNotificationEndDay extends Command
{
    const ROLE_ADMIN = 'REDE_ADMIN';
    const ROLE_OPERATOR = 'LOJA_OPERADOR';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:sendListEndDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Relatório Final do dia' ;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $netWorks = Network::active()->get();
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
        foreach ($netWorks as $netWork){
            $userAdmins =  $this->user->usersAdminNetWork($netWork)->get();
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
            foreach ($userAdmins as $userAdmin){
                  $userAdmin->notify(new ReportEndDay($questionsByRole, $questionByUsers));
            }
        }
        return 0;
    }
}
