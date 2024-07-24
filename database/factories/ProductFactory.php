<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition(): array
    {
        return [
            'category_id' => $this->getCategoryId(),
            'title' => $this->faker->realTextBetween(12, 48),
            'meta_title' => $this->faker->realTextBetween(12, 48),
            'description' => $this->faker->realTextBetween(12, 130),
            'search_keys' => $this->faker->realTextBetween(12, 130),
            'meta_description' => $this->faker->realTextBetween(12, 130),
            'price' => (round(mt_rand(100, 9999) / 10) ) * 10,
            'active' => true,
        ];
    }

    private function getCategoryId()
    {
        $cat = Category::query()->inRandomOrder()->first();
        if (blank($cat))
            return Category::factory(1)->create()->id;
        return $cat->id;
    }
}
