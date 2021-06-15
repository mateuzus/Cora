<?php
namespace Database\Seeders;
use App\Entities\Department;
use App\Entities\Store;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Entities\User::create([
            'name' => 'Thiago Dionizio',
            'email' => 'thiago.dionizio@includetecnologia.com.br',
            'password' => bcrypt('Thiago0010341'),
            'email_verified_at' => now(),
        ]);
        $user->roles()->sync([1]);

        $user = \App\Entities\User::create([
            'name' => 'Mateus Marcelino',
            'email' => 'mateusdsmarcelino@gmail.com',
            'password' => bcrypt('90251900'),
            'email_verified_at' => now(),
        ]);
        $user->roles()->sync([1]);


        $user = \App\Entities\User::create([
            'name' => 'Ricardo Rommaneto',
            'email' => 'ricardo@kikker.com.br',
            'password' => bcrypt('Tasktok12#'),
            'email_verified_at' => now(),
        ]);
        $user->roles()->sync([1]);


        $user = \App\Entities\User::create([
            'name' => 'Gestor - Muffato',
            'email' => 'gestor@muffato.com',
            'password' => bcrypt('Tasktok12#'),
            'email_verified_at' => now(),
        ]);
        $user->roles()->sync([2]);
        $user->networks()->sync([1]);


//
//        $stores = Store::all()->pluck('id');
//        $department = Department::where("code", 'S0101')->get()->first()->id;
//        $user = \App\Entities\User::updateOrCreate([
//            'email' => 'presenca.gondola@muffato.com',
//        ],[
//            'name' => 'Frente de Gôndola - Muffato',
//            'email' => 'presenca.gondola@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->stores()->sync($stores);
//
//
//
//        $user->roles()->sync([4]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->departments()->sync([$department]);
//
//        $user = \App\Entities\User::create([
//            'name' => 'Inventário - Muffato',
//            'email' => 'inventario@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([5]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->departments()->sync([$department]);
//        $user->stores()->sync($stores);
//
//        $user = \App\Entities\User::create([
//            'name' => 'Comprador - Muffato',
//            'email' => 'comprador@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([6]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->departments()->sync([$department]);
//        $user->stores()->sync($stores);
//
//        $user = \App\Entities\User::create([
//            'name' => 'Repositor - Muffato',
//            'email' => 'repositor@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([7]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->departments()->sync([$department]);
//        $user->stores()->sync($stores);
//        $user = \App\Entities\User::create([
//            'name' => 'Gerente de Loja - Muffato',
//            'email' => 'gerente_de_loja@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([8]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->stores()->sync($stores);
//        $user->departments()->sync([$department]);
//
//
//        $user = \App\Entities\User::create([
//            'name' => 'Gerente de Departamento - Muffato',
//            'email' => 'gerente_de_departamento@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([9]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->departments()->sync([$department]);
//        $user->stores()->sync($stores);
//
//
//        $user = \App\Entities\User::create([
//            'name' => 'Gerente de Marketing - Muffato',
//            'email' => 'gerente_de_marketing@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([10]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->stores()->sync($stores);
//
//
//
//
//        $user = \App\Entities\User::create([
//            'name' => 'Operador de Marketing - Muffato',
//            'email' => 'operador_de_marketing@muffato.com',
//            'password' => bcrypt('Tasktok12#'),
//            'email_verified_at' => now(),
//        ]);
//        $user->roles()->sync([11]);
//        $user->networks()->sync([1]);
//        $user->teams()->sync([1]);
//        $user->stores()->sync($stores);

        $stores = Store::where('code','=','1030')->get()->pluck('id');

        $user = \App\Entities\User::create([
            'name' => 'Faturamento',
            'email' => 'fatura.030@muffato.com.br',
            'password' => bcrypt('Tasktok12#'),
            'email_verified_at' => now(),
        ]);
        $user->networks()->sync([1]);
        $user->teams()->sync([1]);
        $user->roles()->sync([5]);
        $user->stores()->sync($stores);
        $user->departments()->sync(69);


        $user = \App\Entities\User::create([
            'name' => 'Supply',
            'email' => 'Analista.trocas@muffato.com.br',
            'password' => bcrypt('Tasktok12#'),
            'email_verified_at' => now(),
        ]);
        $user->networks()->sync([1]);
        $user->teams()->sync([2]);
        $user->roles()->sync([4]);
        $user->stores()->sync($stores);
        $user->departments()->sync(69);



        $user = \App\Entities\User::create([
            'name' => 'Analista da loja 30',
            'email' => 'analista.030@Muffato.com.br',
            'password' => bcrypt('Tasktok12#'),
            'email_verified_at' => now(),
        ]);
        $user->networks()->sync([1]);
        $user->teams()->sync([3]);
        $user->roles()->sync([3]);
        $user->stores()->sync($stores);
        $user->departments()->sync(69);
    }
}
