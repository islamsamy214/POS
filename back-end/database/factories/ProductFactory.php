<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(10),
            'sku' => random_int(10000000, 99999999),
            'details' => $this->faker->realTextBetween(),
            'price' => $this->faker->numberBetween(10, 1000),
            'brand_id' => random_int(1, 10),
            'user_id' => 1
        ];
    }
}
