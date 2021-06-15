<?php
namespace Database\Seeders;
use App\Entities\Flow;
use App\Entities\Store;
use Illuminate\Database\Seeder;

class FlowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flow = Flow::create([
            'network_id'=>1,
            'font_data_id'=>9,
            'name'=>"Lista de rebaixa do preço da merceraria",
            'description'=>"<p>Rebaixa do preço da merceraria</p>",
            'type'=>"pop",
            'schedule'=>"dailyAt",
            'day'=>null,
            'time'=>"08:00",
            'duration_days'=>1,
            'duration_hours'=>0,
            'duration_minutes'=>0,
            'status'=>true,
        ]);

        $store = Store::where('code', '=','1030')->first()->id;
        $flow->stores()->sync([$store]);
        $flowRules = $flow->rules()->createMany([
            [
                'order'=>1,
                'name'=>"Vai fazer a rebaixa de preço",
                'department_id'=>69,
                'store_id'=>$store,
                'team_id'=>1,
                'role_id'=>5,
                'question_type'=>'boolean',
                'type_action'=>'send_to_list',
                'trigger'=>"question_value",
                'trigger_rule'=>"=",
                'trigger_value'=>"SIM",
            ],

            [
                'order'=>2,
                'name'=>"Escolher a regra",
                'department_id'=>69,
                'store_id'=>$store,
                'team_id'=>2,
                'role_id'=>4,
                'question_type'=>'multiple_options',
                'type_action'=>'send_to_list',
                'trigger'=>"every",
                'use_network_config'=>true,
                'rule'=>'price_lowering_rules',

            ],
            [
                'order'=>3,
                'name'=>"Fez a impressão de etiqueta? do produto x no valor {novo_valor}",
                'department_id'=>69,
                'store_id'=>$store,
                'team_id'=>3,
                'role_id'=>3,
                'question_type'=>'boolean',
                'type_action'=>'send_to_list',
                'trigger'=>"question_value",
                'trigger_rule'=>"=",
                'trigger_value'=>"SIM",
            ],
            [
                'order'=>4,
                'name'=>"Fez o cartazeamento de acordo com padrão Muffato",
                'department_id'=>69,
                'store_id'=>$store,
                'team_id'=>3,
                'role_id'=>3,
                'question_type'=>'boolean',
                'type_action'=>'send_to_list',
                'trigger'=>"question_value",
                'trigger_rule'=>"=",
                'trigger_value'=>"SIM",
            ],
            [
                'order'=>4,
                'name'=>"O Cartaz está exposto?",
                'department_id'=>69,
                'store_id'=>$store,
                'team_id'=>3,
                'role_id'=>3,
                'question_type'=>'boolean',
                'type_action'=>'send_to_list',
                'trigger'=>"question_value",
                'trigger_rule'=>"=",
                'trigger_value'=>"SIM",
            ],
            [
                'order'=>5,
                'name'=>"A etiqueta está na gôndola?",
                'department_id'=>69,
                'store_id'=>$store,
//                'team_id'=>3,
//                'role_id'=>5,
//                'question_type'=>'boolean',
//                'type_action'=>'send_to_list',
//                'trigger'=>"question_value",
//                'trigger_rule'=>"=",
//                'trigger_value'=>"SIM",
            ],
        ]);
    }
}
