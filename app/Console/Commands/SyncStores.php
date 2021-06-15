<?php

namespace App\Console\Commands;

use App\Entities\Department;
use App\Entities\FontData;
use App\Entities\Network;
use App\Entities\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:stores {network?} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza as lojas';

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


        if($this->option('all')){
            $networks = Network::active()->get();
        }else{
            $networks = Network::where("id", $this->argument('network'))->get();
        }

        foreach ($networks as $network){
            $fontDataUrl = FontData::where("network_id", $network->id)->where('type', 'api')->where('name', 'Lojas')->first()->details->first()->url;

            $page = 0;
            $items = 0;

            $dados = true;
            while ($dados){
                $this->info('BUSCANDO INFORMAÇÃO DO KIKKER DE LOJAS:' . $page);
                $url = $fontDataUrl."&page=$page";
                $response = Http::get($url);
                if($response->ok()){

                    $data= $response->json()['data'];
                    $items = $items + count($data);

                    if($items >= $response->json()['total']){
                        $dados = false;
                    }
                    else{
                        foreach ($data as $store){
                            Store::updateOrCreate([
                                'network_id'=>$network->id,
                                'description'=>$store['identification'],
                                'name'=>$store['trade_name'],
                                'code'=>$store['code']
                            ], [
                                'network_id'=>$network->id,
                                'description'=>$store['identification'],
                                'name'=>$store['trade_name'],
                                'code'=>$store['code'],
                            ]);
                        }
                        $page++;

                    }



                }else{
                    $dados =false;
                }
            }

            $this->info('FIM DO PROCESSO DE DEPARTAMENTO:');
        }
    }
}
