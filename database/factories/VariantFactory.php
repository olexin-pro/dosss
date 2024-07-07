<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->getProductId(),
            'title' => $this->faker->realTextBetween(12,48),
            'description' => $this->faker->realTextBetween(12,48),
            'price' => (round(mt_rand(100, 9999) / 10) ) * 10,
            'active' => true
        ];
    }

    private function getProductId()
    {
        $prod = Product::query()->inRandomOrder()->first();
        if (blank($prod))
            return Product::factory(1)->createOne()->id;
        return $prod->id;
    }
}
