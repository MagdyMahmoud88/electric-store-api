<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name'        => $this->faker->company(), // توليد اسم شركة وهمي
        'slug'        => $this->faker->unique()->slug(),
        'description' => $this->faker->sentence(),
        'is_active'   => true,
        'logo'        => 'brands/default.png',
        ];
    }
}
