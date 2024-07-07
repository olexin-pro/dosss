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
            'short_description' => $this->faker->realTextBetween(12, 48),
            'description' => $this->faker->realTextBetween(12, 130),
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
