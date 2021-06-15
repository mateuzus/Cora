<?php

namespace App\Console\Commands;

use App\Entities\FontDataDetail;
use App\Entities\Listing;
use App\Entities\PossibleAnswer;
use App\Entities\Question;
use App\Entities\User;
use App\Repositories\OperationStandartDepartmentRepository;
use App\Repositories\OperationStandartRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateListPop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:listPop {pop}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria a lista de acordo com o tempo agendamento de POP';
    /**
     * @var OperationStandartRepository
     */
    private $operationStandartRepository;

    /**
     * Create a new command instance.
     *
     * @param OperationStandartRepository $operationStandartRepository
     */
    public function __construct(OperationStandartRepository $operationStandartRepository)
    {
        parent::__construct();
        $this->operationStandartRepository = $operationStandartRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pop = $this->operationStandartRepository->find($this->argument('pop'));

        $networks = $pop->network->id;
        $stores = $pop->stores;
        $departments = $pop->departments;
        $roles = $pop->roles;
        $teams = $pop->teams;
        $rule = $pop->flow->rules->first();
        $fontData = $pop->flow->fontData;
        $users = $this->getListUsers($networks, $stores, $roles, $departments, $teams);
        $this->info('CRIANDO LISTAS');
        foreach ($users as $user) {
            foreach ($user->stores as $store){
               foreach ($user->departments as $department){
                   foreach ($teams as $team){
                       $description =  "#POP ".$pop->code." - ".$store->name." - ".$department->name." - ".$team->name;

                       $dataList = [
                           'user_id' => $user->id,
                           'flow_id' => $pop->flow->id,
                           'network_id'=>$networks,
                           'store_id'=>$store->id,
                           'department_id'=>$department->id,
                           'team_id'=>$team->id,
                           'pop_id' => $pop->id,
                           'flow_rule_id' => $rule->id,
                           'description' => $description,
                           'creation_date' => Carbon::now()->format('Y-m-d'),
                           'type' => 'pops',
                           'status'=>0,
                           'list_tag' => "$pop->id",
                           'period_start' => Carbon::now(),
                           'period_end' => $pop->getEndDate(),
                       ];
                       $list = Listing::updateOrCreate([
                           'user_id' => $user->id,
                           'network_id'=>$networks,
                           'store_id'=>$store->id,
                           'department_id'=>$department->id,
                           'pop_id' => $pop->id,
                           'description' => "#POP - $pop->code - $pop->sector - $pop->name ",
                           'creation_date' => Carbon::now()->format('Y-m-d'),
                       ], $dataList);

                       $this->info("LISTA $list->id CADASTRADA COM SUCESSO PARA O USUÁRIO $user->email ");
                       //cria a lista
                       switch ($fontData->type){
                           case "manual":
                               $details = FontDataDetail::where("font_data_id", $fontData->id)
                                   ->where('status', 0)
                                   ->get();
                               foreach ($details as $detail){
                                   $this->createQuestion($list, $rule, $detail);
                               }
                               break;
                           default:
                               dd("Ainda não implementado");
                               break;
                       }
                   }


               }
            }
        }

        return 0;
    }


private function createQuestion($list, $rule, $product){



    $dataQuestion = [
        'list_id' => $list->id,
        'rule_id'=>$rule->id,
        'description' => $rule->name . " - " . $product->description,
        'question_type' => $rule->question_type,
        'quantity' => $product->value,
        'status' => 0,
    ];



    $question = Question::updateOrCreate(
        [
            'list_id' => $list->id,
            'description' => $dataQuestion['description'],
        ],
        $dataQuestion
    );
    $this->info("PERGUNTA $question->id CADASTRADA COM SUCESSO");

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
        $this->info("RESPOSTAS DA PERGUNTA $question->id CADASTRADA COM SUCESSO");
    }
}

    private function getListUsers($network, $stores, $roles, $departments, $teams)
    {
        $users = User::whereHas("networks", function ($query) use ($network) {
            return $query->where("networks.id", $network);
        })
            ->whereHas("roles", function ($query) use ($roles) {
                return $query->whereIn("roles.id", $roles->pluck('id'));
            })
            ->whereHas("stores", function ($query) use ($stores) {
                return $query->whereIn("stores.id", $stores->pluck('id'));
            })
            ->whereHas("departments", function ($query) use ($departments) {
                return $query->whereIn("departments.id", $departments->pluck('id'));
            })
            ->whereHas("teams", function ($query) use ($teams) {
                return $query->whereIn("teams.id", $teams->pluck('id'));
            })
           ->get();
        return $users;
    }
}
