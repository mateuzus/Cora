<?php

namespace Database\Seeders;

use App\Entities\Department;
use App\Entities\OperationStandart;
use App\Entities\OperationStandartTask;
use App\Entities\Store;
use Illuminate\Database\Seeder;

class PopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CRIAR UM POP
        $pop1 = OperationStandart::create([
            'network_id'=>1,
            'flow_id'=>1,
            'code' =>'POP_MERC_001 - 1',
            'sector'=>'Mercearia',
            'name'=>'Precificação e Rebaixa de preço - Rebaixa por vencimento',
            'target'=>'Orientar o Processo de solicitação de rebaixa de preço, para produtos de validade curta e baixo giro, a fim de minimizar perdas.',
            'references'=>"",
            'material'=>'Microcomputador, acesso ao e-mail, impressora.',
            'schedule'=>"weeklyOn",
            'day'=>'1',
            'time'=>'08:00',
            'duration_days'=>5,
            'duration_hours'=>0,
            'duration_minutes'=>0,
            'description' => "
                        Rebaixa por vencimento
                             Supply envia relatório para a matriz de produtos de validade curta, em dia específico da semana para cada loja;
                             Após aprovação, matriz envia relatório com os valores dos produtos com rebaixa de preço;
                             Imprimir no CPD etiqueta branca com código da rebaixa de preço e colar sobre o idem do produto;
                             E prosseguir ao cartazeamento de acordo com padrão Muffato;
                        Rebaixa por venda e concorrência
                             Verificar os produtos com baixo giro;
                             Sugerir ao gestor a rebaixa do produto;
                             Após o parecer do Gestor, prosseguir com precificação;",
            'status'=>1,
        ]);

        //lojas
        $stores = Store::where('code', '=','1030')->get()->pluck('id');
        $pop1->stores()->sync($stores);

        //roles
        $pop1->roles()->sync([3]);

        //departments
        $department = Department::where("code", 'S0101')->get()->first()->id;
        $pop1->departments()->sync([$department]);
        $pop1->teams()->sync([1]);



        //CRIAR UM POP
        $pop2 = OperationStandart::create([
            'network_id'=>1,
            'flow_id'=>1,
            'code' =>'POP_MERC_001 - 2',
            'sector'=>'Mercearia',
            'name'=>'Precificação e Rebaixa de preço - Rebaixa por venda e concorrência',
            'target'=>'Orientar o Processo de solicitação de rebaixa de preço, para produtos de validade curta e baixo giro, a fim de minimizar perdas.',
            'references'=>'',
            'material'=>'Microcomputador, acesso ao e-mail, impressora.',
            'schedule'=>"weeklyOn",
            'day'=>'1',
            'time'=>'08:00',
            'duration_days'=>0,
            'duration_hours'=>0,
            'duration_minutes'=>10,
            'description' => "
                        Rebaixa por vencimento
                             Supply envia relatório para a matriz de produtos de validade curta, em dia específico da semana para cada loja;
                             Após aprovação, matriz envia relatório com os valores dos produtos com rebaixa de preço;
                             Imprimir no CPD etiqueta branca com código da rebaixa de preço e colar sobre o idem do produto;
                             E prosseguir ao cartazeamento de acordo com padrão Muffato;
                        Rebaixa por venda e concorrência
                             Verificar os produtos com baixo giro;
                             Sugerir ao gestor a rebaixa do produto;
                             Após o parecer do Gestor, prosseguir com precificação;",
            'status'=>1,
        ]);

        //lojas
        $pop2->stores()->sync($stores);
        //roles
        $pop2->roles()->sync([3]);

        //departments
        $department = Department::where("code", 'S0101')->get()->first()->id;
        $pop2->departments()->sync([$department]);
        $pop2->teams()->sync([1]);
    }
}
