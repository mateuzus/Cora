<?php

namespace Database\Seeders;

use App\Entities\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withBasicAuth('kikker', 'MuffKi@2021')
            ->get('https://api.muffato.io/zk-qa/RESTAdapter/Kikker/GetProdutos?top=100&skip=0');
        if ($response->ok()) {
            $json = $response->json();

            foreach ($json['row'] as $j) {

                Product::updateOrCreate(
                    [
                        'network_id' => 1,
                        'code' => $j['cod_erp']
                    ],
                    [
                        'network_id' => 1,
                        'code' => $j['cod_erp'],
                        'description' => $j['descricao'],
                        'ean_code' => $j['ean']??"",
                    ]);
            }
        }


    }
}
