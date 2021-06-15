<?php

namespace App\Console\Commands;

use App\Entities\Listing;
use App\Entities\PossibleAnswer;
use App\Entities\Question;
use App\Entities\User;
use App\Repositories\RoutineRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateListRoutine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:listRoutine {routine}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria lista de acordo com a rotina';
    /**
     * @var RoutineRepository
     */
    private $routineRepository;

    /**
     * Create a new command instance.
     *
     * @param RoutineRepository $routineRepository
     */
    public function __construct(RoutineRepository $routineRepository)
    {
        parent::__construct();
        $this->routineRepository = $routineRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routine = $this->routineRepository->find($this->argument('routine'));
        $network = $routine->network->id;
        //        $stores = $routine->stores->pluck("id")a;
        $stores = [48];
        $roles = $routine->roles->pluck("id");
        $users = $this->getListUsers($network, $stores, $roles);
        $this->info('CRIANDO LISTAS');
        foreach ($users as $user) {

            $dataList = [
                'description' => "#ROTINA - $routine->name",
                'operator_id' => $user->operator->id,
                'creation_date' => Carbon::now()->format('Y-m-d'),
                'type' => 'ABERTURA_FECHAMENTO',
                'status' => "ATIVA",
                'list_tag' => "$routine->id",
                'routine_id' => $routine->id,
                'period_start' => "08:00:00",
                'period_end' => "17:00:00",
            ];
            $list = Listing::updateOrCreate([
                'description' => "#ROUTINE - $routine->name",
                'operator_id' => $user->operator->id,
                'creation_date' => Carbon::now()->format('Y-m-d'),
            ], $dataList);

            $this->info("LISTA $list->id CADASTRADA COM SUCESSO PARA O USUÁRIO $user->email ");
            //cria a lista
            $tasks = $routine->tasks;
            foreach ($tasks as $task) {
                $dataTask = [
                    'list_id' => $list->id,
                    'description' => $task->description,
                    'mandatory' => $task->required,
                    'question_status' => 'NAO_RESPONDIDA',
                    'question_tipo' => $task->type,
                    'weight_question' => $task->weight,
                    'has_action' => $task->has_action,
                    'link_video' => $task->video,
                    'amount' => $task->quantity,
                ];
                $question = Question::updateOrCreate(
                    [
                        'lista_id' => $list->id,
                        'descricao' => $task->description,
                    ],
                    $dataTask
                );
                $this->info("PERGUNTA $question->id CADASTRADA COM SUCESSO");
                $possibleAnswer = PossibleAnswer::updateOrCreate(
                    [
                        'question_id'=>$question->id,
                        'description'=>"SIM",
                    ],
                    [
                        'question_id'=>$question->id,
                        'description'=>"SIM",
                    ]
                );
                $possibleAnswer = PossibleAnswer::updateOrCreate(
                    [
                        'question_id'=>$question->id,
                        'description'=>"NAO",
                    ],
                    [
                        'question_id'=>$question->id,
                        'description'=>"NAO",
                    ]
                );
                $possibleAnswer = PossibleAnswer::updateOrCreate(
                    [
                        'question_id'=>$question->id,
                        'description'=>"PARCIAL",
                    ],
                    [
                        'question_id'=>$question->id,
                        'description'=>"PARCIAL",
                    ]
                );
                $this->info("RESPOSTAS DA PERFUNTA $question->id CADASTRADA COM SUCESSO");
            }
        }

        return 0;
    }

    private function getListUsers($network, array $stores, $roles)
    {
        $users = User::whereHas("networks", function ($query) use ($network) {
            return $query->where("id", $network);
        })
            ->whereHas("roles", function ($query) use ($roles) {
                return $query->whereIn("id", $roles);
            })
            ->whereHas("stores", function ($query) use ($stores) {
                return $query->whereIn("id", $stores);
            })
            ->with("operator")->get();
        return $users;
    }
}
