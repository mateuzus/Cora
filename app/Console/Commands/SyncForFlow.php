<?php

namespace App\Console\Commands;

use App\Entities\Flow;
use App\Entities\FontData;
use App\Entities\FontDataDetail;
use App\Entities\Listing;
use App\Entities\Network;
use App\Entities\PossibleAnswer;
use App\Entities\Question;
use App\Entities\Store;
use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncForFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:listFlow {flow}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria a lista de acordo com o fluxo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $flow = Flow::find($this->argument('flow'));

        $networks = $flow->network->id;
        $stores = $flow->stores;
        $departments = $flow->departments;
        $roles = $flow->roles;
        $teams = $flow->teams;
        $rule = $flow->rules->first();
        $fontData = $flow->fontData;
        $users = $this->getListUsers($networks, $stores, $roles, $departments, $teams);
        dd($users);
        foreach ($users as $user) {
            $this->info("CRIANDO LISTAS PARA O USUÁRIO: $user->name ");
            foreach ($user->stores as $store) {
                foreach ($user->departments as $department) {
                    foreach ($teams as $team) {
                        $description = "#" . $flow->name . " - " . $store->name . " - " . $department->name . " - " . $team->name;

                        $dataList = [
                            'user_id' => $user->id,
                            'flow_id' => $flow->id,
                            'network_id' => $networks,
                            'store_id' => $store->id,
                            'department_id' => $department->id,
                            'team_id' => $team->id,
                            'flow_rule_id' => $rule->id,
                            'description' => $description,
                            'creation_date' => Carbon::now()->format('Y-m-d'),
                            'type' => 'pops',
                            'status' => 0,
                            'list_tag' => "$flow->id",
                            'period_start' => Carbon::now(),
                            'period_end' => $flow->getEndDate(),
                        ];
                        $list = Listing::updateOrCreate([
                            'user_id' => $user->id,
                            'network_id' => $networks,
                            'store_id' => $store->id,
                            'department_id' => $department->id,
                            'description' => $description,
                            'creation_date' => Carbon::now()->format('Y-m-d'),
                        ], $dataList);

                        $this->info("LISTA $list->id CADASTRADA COM SUCESSO PARA O USUÁRIO $user->email ");
                        //cria a lista
                        switch ($fontData->type) {
                            case "manual":
                                $details = FontDataDetail::where("font_data_id", $fontData->id)
                                    ->where('status', 0)
                                    ->get();
                                foreach ($details as $detail) {
                                    $this->createQuestion($list, $rule, $detail);
                                }
                                break;
                            case "api":
                                $this->getQuestioByFontData($fontData);
                                break;
                            default:
                                $this->getQuestioByFile($fontData);
                                break;
                        }
                    }


                }
            }
        }

        return 0;
    }

    private function createQuestion($list, $rule, $product)
    {


        $dataQuestion = [
            'list_id' => $list->id,
            'rule_id' => $rule->id,
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

        if ($question->question_type == "boolean") {
            $possibleAnswer = PossibleAnswer::updateOrCreate(
                [
                    'question_id' => $question->id,
                    'description' => "SIM",
                    'value' => "SIM",
                ],
                [
                    'question_id' => $question->id,
                    'description' => "SIM",
                    'value' => "SIM",
                ]
            );
            $possibleAnswer = PossibleAnswer::updateOrCreate(
                [
                    'question_id' => $question->id,
                    'description' => "NÃO",
                    'value' => "NAO",
                ],
                [
                    'question_id' => $question->id,
                    'description' => "NÃO",
                    'value' => "NAO",
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

    private function getQuestioByFontData(FontData $fontData)
    {
        $fontDataUrl = $fontData->details->first()->url;

        $page = 0;
        $items = 0;

        $dados = true;
        while ($dados) {
            $this->info('BUSCANDO INFORMAÇÃO DO KIKKER DE LOJAS:' . $page);
            $url = $fontDataUrl . "&page=$page";
            $response = Http::get($url);
            if ($response->ok()) {

                $data = $response->json()['data'];
                $items = $items + count($data);

                if ($items >= $response->json()['total']) {
                    $dados = false;
                } else {
                    foreach ($data as $product) {
dd($product);
                    }
                    $page++;

                }


            } else {
                $dados = false;
            }
        }

        $this->info('FIM DO PROCESSO:');
    }

    private function getQuestioByFile($fontData)
    {
    }


}
