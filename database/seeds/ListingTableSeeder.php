<?php

namespace Database\Seeders;

use App\Entities\Listing;
use App\Entities\Product;
use App\Entities\Question;
use Illuminate\Database\Seeder;

class ListingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Listing::factory()->times(10000)->create();
        Listing::factory()
            ->times(1000)
            ->has(
                Question::factory()
                    ->count(100)
                    ->state(function (array $attributes, Listing $listing) {
                        return ['list_id' =>$listing->id];
                    }))
            ->create();
    }
}
