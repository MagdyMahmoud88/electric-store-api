<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'icon' => $this->faker->randomElement(['fa-solid fa-tv', 'fa-solid fa-laptop', 'fa-solid fa-mobile-screen', 'fa-solid fa-headphones', 'fa-solid fa-camera']),
            'color' => $this->faker->hexColor(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'products_count' => $this->faker->numberBetween(0, 100),

        ];
    }
}
