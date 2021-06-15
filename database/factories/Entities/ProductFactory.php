<?php

namespace Database\Factories\Entities;

use App\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

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
            'description'=>$this->faker->name,
            'ean_code'=>$this->faker->creditCardNumber,
        ];
    }
}
