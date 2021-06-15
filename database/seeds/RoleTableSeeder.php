<?php
namespace Database\Seeders;
use App\Entities\Permission;
use App\Entities\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>"Administrador", "slug"=>"admin"]);
        $role = Role::create(['name'=>"Gestor", "slug"=>"manager"]);
        $permissions = Permission::where('id', '>', 5)->get()->pluck('id');
        $role->permissions()->sync($permissions);
//        $role = Role::create(['name'=>"Frente de Gôndola", "slug"=>"gondola_front"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Inventariante", "slug"=>"inventory"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Comprador", "slug"=>"buyer"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Repositor", "slug"=>"replenisher"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Gerente de Loja", "slug"=>"manager_store"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Gerente de Departamento", "slug"=>"manager_department"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Gerente de Marketing", "slug"=>"manager_marketing"]);
//        $role->permissions()->sync([1, 38]);
//        $role = Role::create(['name'=>"Operador de Marketing", "slug"=>"operator_marketing"]);
//        $role->permissions()->sync([1, 38]);

        $role = Role::create(['name'=>"Analista", "slug"=>"analyst"]);
        $role->permissions()->sync([1, 38]);

        $role = Role::create(['name'=>"Supply", "slug"=>"supply"]);
        $role->permissions()->sync([1, 38]);

        $role = Role::create(['name'=>"Faturmento de Nota", "slug"=>"bill_billing"]);
        $role->permissions()->sync([1, 38]);
    }
}
