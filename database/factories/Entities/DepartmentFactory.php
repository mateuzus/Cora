<?php

namespace Database\Factories\Entities;

use App\Entities\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'network_id'=>1,
            'code'=>$this->faker->creditCardNumber,
            'name'=>$this->faker->name,
            'status'=>1,
        ];
    }
}
