<?php

namespace Database\Factories\Entities;

use App\Entities\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'network_id'=>1,
            'name'=>"Squad - {$this->faker->name} ",
            'description'=>"Squad - {$this->faker->text} "
        ];
    }
}
