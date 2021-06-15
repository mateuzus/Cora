<?php

namespace Database\Seeders;

use App\Entities\FontData;
use App\Entities\FontDataDetail;
use App\Entities\Network;
use Illuminate\Database\Seeder;

class FontDataTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fontData1 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Lojas",
        ]);

        FontDataDetail::create([
            'font_data_id' => 1,
            'description' => "APi de comunicação com o Kikker",
            'url' => 'https://api.kikker.com.br/api/v1/workflow/stores?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);

        $fontData2 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Departamentos",
        ]);
        FontDataDetail::create([
            'font_data_id' => 2,
            'description' => "APi de comunicação com o Kikker",
            'url' => 'https://api.kikker.com.br/api/v1/workflow/departments?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);

        $fontData3 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Produtos",
        ]);

        FontDataDetail::create([
            'font_data_id' => 3,
            'description' => "APi de comunicação com o Kikker",
            'url' => 'https://api.kikker.com.br/api/v1/workflow/products?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);

        $fontData4 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Alerta de Estoque Virtual",
        ]);


        FontDataDetail::create([
            'font_data_id' => 3,
            'description' => "APi de comunicação com o Kikker",
            'url' => ' https://api.kikker.com.br/api/v1/workflow/alerta-estoque-virtual?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);


        $fontData5 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Ruptura comercial",
        ]);

        FontDataDetail::create([
            'font_data_id' => 5,
            'description' => "APi de comunicação com o Kikker",
            'url' => ' https://api.kikker.com.br/api/v1/workflow/ruptura-comercial?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);

        $fontData6 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Ruptura Operacional",
        ]);

        FontDataDetail::create([
            'font_data_id' => 6,
            'description' => "APi de comunicação com o Kikker",
            'url' => ' https://api.kikker.com.br/api/v1/workflow/ruptura-operacional?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);

        $fontData7 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Estoque Excedente",
        ]);

        FontDataDetail::create([
            'font_data_id' => 7,
            'description' => "APi de comunicação com o Kikker",
            'url' => ' https://api.kikker.com.br/api/v1/workflow/estoque-excedente?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);
        $fontData8 = FontData::create([
            'network_id' => 1,
            'type' => "api",
            'name' => "Alerta de Rupturas",
        ]);

        FontDataDetail::create([
            'font_data_id' => 8,
            'description' => "APi de comunicação com o Kikker",
            'url' => ' https://api.kikker.com.br/api/v1/workflow/alerta_ruptura?token=kmkjnhdygbebdgvbfcvsg7864df29jkd8h267',
            'status' => 0,
        ]);



        //font de dados dos pop


        $fontData9 = FontData::create([
            'network_id' => 1,
            'type' => "manual",
            'name' => "POP_MERC_001 - 1",
        ]);

        FontDataDetail::create([
            'font_data_id' => 9,
            'ean_code' => "12345",
            'description' => "PRODUTO 01 TESTE",
            'status' => 0,
            'value' => 1.99,
        ]);
        FontDataDetail::create([
            'font_data_id' => 9,
            'ean_code' => "678910",
            'description' => "PRODUTO 02 TESTE",
            'status' => 0,
        ]);
        FontDataDetail::create([
            'font_data_id' => 9,
            'ean_code' => "13579",
            'description' => "PRODUTO 03 TESTE",
            'status' => 0,
        ]);
        FontDataDetail::create([
            'font_data_id' => 9,
            'ean_code' => "246810",
            'description' => "PRODUTO 04 TESTE",
            'status' => 0,
        ]);


        $fontData10 = FontData::create([
            'network_id' => 1,
            'type' => "manual",
            'name' => "POP_MERC_001 - 2",
        ]);

        FontDataDetail::create([
            'font_data_id' => 10,
            'ean_code' => "12345",
            'description' => "PRODUTO 05 TESTE",
            'status' => 0,
        ]);
        FontDataDetail::create([
            'font_data_id' => 10,
            'ean_code' => "678910",
            'description' => "PRODUTO 06 TESTE",
            'status' => 0,
        ]);
        FontDataDetail::create([
            'font_data_id' => 10,
            'ean_code' => "13579",
            'description' => "PRODUTO 07 TESTE",
            'status' => 0,
        ]);
        FontDataDetail::create([
            'font_data_id' => 10,
            'ean_code' => "246810",
            'description' => "PRODUTO 08 TESTE",
            'status' => 0,
        ]);

    }
}
