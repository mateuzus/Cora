<?php

namespace Database\Seeders;

use App\Entities\Routine;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoutinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Routine::create([
            'name' => "TesteApi",
            'schedule' => '19/04/2021',
            'day' => 19,
            'time' => Carbon::now('America/Brasilia'),
            'image' => null,
            'description' => 'Descricao do teste routinas',
            'status' => true
        ]);
    }
}
