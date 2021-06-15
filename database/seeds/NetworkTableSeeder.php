<?php
namespace Database\Seeders;
use App\Entities\Network;
use Illuminate\Database\Seeder;

class NetworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $network = Network::create([
            'name' => "Muffato",
            'description' => "Muffato",
            'status' => true
        ]);
        $network->config()->createMany([
            [
                'network_id'=>$network->id,
                'price_lowering_rules'=>30,
            ],
            [
                'network_id'=>$network->id,
                'price_lowering_rules'=>40,
            ],
            [
                'network_id'=>$network->id,
                'price_lowering_rules'=>50,
            ],

        ]);

    }
}
