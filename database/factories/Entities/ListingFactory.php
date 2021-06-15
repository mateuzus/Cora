<?php

namespace Database\Factories\Entities;

use App\Entities\Department;
use App\Entities\Listing;
use App\Entities\Network;
use App\Entities\Product;
use App\Entities\Store;
use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class ListingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Listing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $type = collect([
            'flow_of_work' => "Fila de trabalho",
            'prices' => 'Lista de preços',
            'audits' => 'Lista de auditorias',
            'pops' => 'Lista de procedimento operacional padrão',
            'routines' => 'Lista de rotinas',
            'noncompliances' => 'Lista de inconformidades',
            'resupplements' => 'Lista de resuplementos'
        ])->keys()->random(1)->first();

        $status = collect([
            0 => "NÃO INICIADA",
            1 => "INICIADA",
            2 => "FINALIZADA",
            3 => "FINALIZADA MAS NÃO COMPLETA"
        ])->keys()->random(1)->first();
        $network = Network::find(1);
        $store = Store::find($this->faker->numberBetween(1,50));
        $department = Department::find($this->faker->numberBetween(1,100));

        $user =User::active()->usersNetWork(1)->withoutAdmin()->get()->random(1)->first();

            return [
                'network_id' => $network->id,
                'store_id' => $store->id,
                'department_id' => $department->id,
                'user_id' => $user->id,

                'description' => "#$network->name - $store->name - $department->name",

                'creation_date' => Carbon::now()->subDays($this->faker->numberBetween(0,90)),
                'type' => $type,
                'status' => $status,
                'list_tag' => null,
                'period_end' => $this->faker->dateTime,
                'period_start' => $this->faker->dateTime,
                'pop_id' => null,
                'routine_id' => null,
                'flow_id' => null
            ];

    }
}
