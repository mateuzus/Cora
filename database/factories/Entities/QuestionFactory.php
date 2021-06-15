<?php

namespace Database\Factories\Entities;

use App\Entities\Listing;
use App\Entities\Product;
use App\Entities\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $type = collect([
            'number_integer' => "Número Inteiro",
            'number_decimal' => "Número decimal",
            'boolean' => "Verdadeiro e falso",

        ])->keys()->random(1)->first();
        $product = Product::find($this->faker->numberBetween(1,100));
        return [
            'list_id'=>Listing::factory(),
            'product_id'=>$product->id,
            'description'=>$this->faker->text,
            'mandatory'=>$this->faker->boolean,
            'question_status'=>$this->faker->boolean,
            'question_type'=>$type,
            'weight_question'=>$this->faker->numberBetween(1, 100),
            'has_action'=>$this->faker->boolean,
            'link_video'=>$this->faker->imageUrl(),
            'amount'=>$this->faker->numberBetween(1,100),
            'ean_code'=>$this->faker->creditCardNumber,
        ];
    }
}
