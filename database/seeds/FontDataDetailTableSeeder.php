<?php

namespace Database\Seeders;

use App\Entities\FontData;
use App\Entities\FontDataDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FontDataDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $formDatas = FontData::all();

       foreach ($formDatas as $formData) {
              $formData->details()->create(
                  [
                      'ean_code' => Str::random(5),
                      'description' => Str::random(50),
                      'status' => 0,
                      'value' => 1,
                      'url' => 'https://www.google.com',
                      'utilized_at' => Carbon::now()
                  ]
              );
       }


    }
}
