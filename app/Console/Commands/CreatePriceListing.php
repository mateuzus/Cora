<?php

namespace App\Console\Commands;

use App\Entities\Listing;
use App\Entities\PossibleAnswer;
use App\Entities\Question;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreatePriceListing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:listingPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma lista de preços';

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
        //pega da api o retorno e cadastra
        $results= $this->getResultAPi();

$results = collect($results['body']['lojas']);

        foreach ($results->groupBy('store_code') as $store_code=>$tasks){

            $dataList = [
                'descricao' => "#PRECO - $store_code",
                'operador_id' => 105,
                'data_criacao' => Carbon::now()->format('Y-m-d'),
                'tipo' => 'prices',
                'status' => "ATIVA",
                'vigencia_inicio' => "08:00:00",
                'vigencia_fim' => "17:00:00",
            ];

            $list = Listing::updateOrCreate([
                'descricao' => "#PRECO - $store_code",
                'operador_id' => 105,
                'data_criacao' => Carbon::now()->format('Y-m-d'),
            ], $dataList);
            $this->info("LISTA $list->id CADASTRADA COM SUCESSO PARA O USUÁRIO  ");
            foreach ($tasks as $task) {
                $dataTask = [
                    'lista_id' => $list->id,
                    'descricao' => $task['product_name'],
                    'obrigatoria' => true,
                    'pergunta_status' => 'NAO_RESPONDIDA',
                    'pergunta_tipo' => 'PRINCING',
                    'peso_pergunta' =>1,
                    'tem_acao' => false,
                    'link_video' => false,
                    'quantidade' => $task['net_sales_unit_price']
                ];
                $question = Question::updateOrCreate(
                    [
                        'lista_id' => $list->id,
                        'descricao' => $task['product_name'],
                    ],
                    $dataTask
                );
                $this->info("PERGUNTA $question->id CADASTRADA COM SUCESSO");
                $possibleAnswer = PossibleAnswer::updateOrCreate(
                    [
                        'pergunta_id'=>$question->id,
                        'descricao'=>"SIM",
                    ],
                    [
                        'pergunta_id'=>$question->id,
                        'descricao'=>"SIM",
                    ]
                );
                $possibleAnswer = PossibleAnswer::updateOrCreate(
                    [
                        'pergunta_id'=>$question->id,
                        'descricao'=>"NAO",
                    ],
                    [
                        'pergunta_id'=>$question->id,
                        'descricao'=>"NAO",
                    ]
                );
                $this->info("RESPOSTAS DA PERFUNTA $question->id CADASTRADA COM SUCESSO");
            }
        }
    }

    private function getResultAPi()
    {
        $url = 'https://api.kikker.com.br/api/v1/workflow/sales-price';
        $response = Http::withHeaders([
            'token'=> '9D3E84EF83C6B2366F9D32EE83DB7'
        ])
            ->retry(3, 100)
            ->get($url);
        try {
            $body = $response->body();
            $json = $response->json();
            $status = $response->status();
            $successful = $response->successful();

            if($status === 200){
                return [
                    'success'=>$successful,
                    'body'=>$json,
                    'response'=>$response
                ];
            }else{
                return [
                    'success'=>false,
                    'body'=>$body,
                    'response'=>$response
                ];
            }
        }catch (\Exception $exception){

            $exception_message = $exception->getMessage();
            $message = "#ERRO MUFFATO - INFORMÇÕES DO API DO KIKKER"
                ." - URL:"              . $url

                ." - MENSAGEM:"         . $exception_message;
            $this->error($message);
            Log::error($message);
            return [
                'success'=>false,
                'body'=>null,
                'response'=>$response
            ];
        }
    }
}
