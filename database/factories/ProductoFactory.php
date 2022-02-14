<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => $this->faker->url(),
            'brand' => Str::random(10), 
            'price' => $this->faker->randomFloat(1, 20, 30),
            'price_sale' => $this->faker->randomFloat(1, 20, 30),
            'category' => $this->faker->sentence(),
            'stock' => $this->faker->optional($weight = 100)->randomDigit,
        ];
    }
}
