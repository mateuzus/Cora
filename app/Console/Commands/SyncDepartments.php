<?php

namespace App\Console\Commands;

use App\Entities\Department;
use App\Entities\FontData;
use App\Entities\Network;
use App\Entities\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncDepartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:departments {network?} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza departmentos';

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
            $fontDataDepartmentUrl = FontData::where("network_id", $network->id)->where('type', 'api')->where('name', 'Departamentos')->first()->details->first()->url;

            $page = 0;
            $items = 0;

            $dados = true;
            while ($dados){
                $this->info('BUSCANDO INFORMAÇÃO DO KIKKER DE DEPARTAMENTO:' . $page);
                $url = $fontDataDepartmentUrl."&page=$page";
                $response = Http::get($url);
                if($response->ok()){

                    $data= $response->json()['data'];
                    $items = $items + count($data);
                    if($items = $response->json()['total']){
                        foreach ($data as $department){
                            $department = Department::updateOrCreate([
                                'network_id'=>$network->id,
                                'code'=>$department['code'],
                                'name'=>$department['name'],
                            ], [
                                'network_id'=>$network->id,
                                'code'=>$department['code'],
                                'name'=>$department['name'],
                                'status'=>1,
                            ]);
                        }
                        $dados = false;
                    }elseif ($items > $response->json()['total']){
                        $dados = false;
                    }else{
                        foreach ($data as $department){
                            $department = Department::updateOrCreate([
                                'network_id'=>$network->id,
                                'code'=>$department['code'],
                                'name'=>$department['name'],
                            ], [
                                'network_id'=>$network->id,
                                'code'=>$department['code'],
                                'name'=>$department['name'],
                                'status'=>1,
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
