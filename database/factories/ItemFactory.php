<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1,10),
            'name' => $this->faker->word,
            'type' => rand(1,5),
            'status'=> $this->faker->text(20),
            'detail' => $this->faker->realText,
        ];
    }
}
