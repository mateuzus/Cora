<?php
namespace Database\Seeders;
use App\Entities\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ler o csv e cadastra
        $csv = Reader::createFromPath(public_path( 'csv/mercadologico.csv'), 'r');


        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        foreach ($records as $record){
           $department = Department::updateOrCreate(
               [ 'network_id'=>1,
                   'code'=>$record['COD_ERP_DEPARTAMENTO']
               ],
               [
               'network_id'=>1,
               'code'=>$record['COD_ERP_DEPARTAMENTO'],
               'name'=>$record['NOME_DEPARTAMENTO'],
               'status'=>true,
           ]);

        }



    }
}
