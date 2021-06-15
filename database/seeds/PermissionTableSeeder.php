<?php

namespace Database\Seeders;

use App\Entities\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'Inicial','slug'=>'dashboard.index']);
        Permission::create(['name'=>'Listagem de Rede','slug'=>'networks.index']);
        Permission::create(['name'=>'Cadastrar Rede','slug'=>'networks.store']);
        Permission::create(['name'=>'Atualizar Rede','slug'=>'networks.edit']);
        Permission::create(['name'=>'Apagar Rede','slug'=>'networks.delete']);

        Permission::create(['name'=>'Listagem de Usuário','slug'=>'users.index']);
        Permission::create(['name'=>'Cadastrar Usuário','slug'=>'users.store']);
        Permission::create(['name'=>'Atualizar Usuário','slug'=>'users.edit']);
        Permission::create(['name'=>'Apagar Usuário','slug'=>'users.delete']);


        Permission::create(['name'=>'Listagem de POP','slug'=>'operationstandart.index']);
        Permission::create(['name'=>'Cadastrar POP','slug'=>'operationstandart.store']);
        Permission::create(['name'=>'Atualizar POP','slug'=>'operationstandart.edit']);
        Permission::create(['name'=>'Apagar POP','slug'=>'operationstandart.delete']);



        Permission::create(['name'=>'Listagem de Rotinas','slug'=>'routines.index']);
        Permission::create(['name'=>'Cadastrar Rotinas','slug'=>'routines.store']);
        Permission::create(['name'=>'Atualizar Rotinas','slug'=>'routines.edit']);
        Permission::create(['name'=>'Apagar Rotinas','slug'=>'routines.delete']);


        Permission::create(['name'=>'Listagem de Fluxos de Trabalho','slug'=>'flows.index']);
        Permission::create(['name'=>'Cadastrar Fluxos de Trabalho','slug'=>'flows.store']);
        Permission::create(['name'=>'Atualizar Fluxos de Trabalho','slug'=>'flows.edit']);
        Permission::create(['name'=>'Apagar Fluxos de Trabalho','slug'=>'flows.delete']);


        Permission::create(['name'=>'Listagem de Preços','slug'=>'prices.index']);
        Permission::create(['name'=>'Cadastrar Preços','slug'=>'prices.store']);
        Permission::create(['name'=>'Atualizar Preços','slug'=>'prices.edit']);
        Permission::create(['name'=>'Apagar Preços','slug'=>'prices.delete']);


        Permission::create(['name'=>'Listagem de Auditorias','slug'=>'audits.index']);
        Permission::create(['name'=>'Cadastrar Auditorias','slug'=>'audits.store']);
        Permission::create(['name'=>'Atualizar Auditorias','slug'=>'audits.edit']);
        Permission::create(['name'=>'Apagar Auditorias','slug'=>'audits.delete']);


        Permission::create(['name'=>'Listagem de Lojas','slug'=>'stores.index']);
        Permission::create(['name'=>'Cadastrar Lojas','slug'=>'stores.store']);
        Permission::create(['name'=>'Atualizar Lojas','slug'=>'stores.edit']);
        Permission::create(['name'=>'Apagar Lojas','slug'=>'stores.delete']);



        Permission::create(['name'=>'Listagem de Departamentos','slug'=>'departments.index']);
        Permission::create(['name'=>'Cadastrar Departamentos','slug'=>'departments.store']);
        Permission::create(['name'=>'Atualizar Departamentos','slug'=>'departments.edit']);
        Permission::create(['name'=>'Apagar Departamentos','slug'=>'departments.delete']);


        Permission::create(['name'=>'Responder lista','slug'=>'lists_by_user.index']);


        Permission::create(['name'=>'Visualizar a configurações do negócio','slug'=>'network_configs.index']);
        Permission::create(['name'=>'Cadastrar a configurações do negócio','slug'=>'network_configs.store']);
        Permission::create(['name'=>'Atualizar a configurações do negócio','slug'=>'network_configs.edit']);
        Permission::create(['name'=>'Apagar a configurações do negócio','slug'=>'network_configs.delete']);



    }
}
