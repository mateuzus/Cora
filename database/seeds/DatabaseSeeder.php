<?php
namespace Database\Seeders;
use App\Entities\Flow;
use App\Entities\FontData;
use App\Entities\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(NetworkTableSeeder::class);
         $this->call(PermissionTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(TeamTableSeeder::class);
         $this->call(FontDataTableSeeder::class);
         $this->call(StoreTableSeeder::class);
         $this->call(DepartmentsTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(FlowsTableSeeder::class);
         $this->call(PopTableSeeder::class);
    }
}
