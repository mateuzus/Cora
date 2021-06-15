<?php

namespace Database\Seeders;

use App\Entities\Team;
use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'network_id'=>1,
            'name'=>"Faturamento de nota",
            'description'=>"Faturamento de nota fiscal"
        ]);

        Team::create([
            'network_id'=>1,
            'name'=>"Supply",
            'description'=>"Time de Supply"
        ]);
        Team::create([
            'network_id'=>1,
            'name'=>"Gestão de mercearia.",
            'description'=>"Gestão de mercearia."
        ]);
    }
}
