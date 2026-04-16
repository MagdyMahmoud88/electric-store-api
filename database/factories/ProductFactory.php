<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        $names = ['كشاف', 'مفتاح', 'سلك', 'قاطع', 'نجفة', 'سبوت لايت', 'فيشة'];
        return [
           'category_id' => \App\Models\Category::factory(),
           'name' => $this->faker->randomElement($names),
           'description' => $this->faker->paragraph(),
           'price' => $this->faker->randomFloat(2, 10, 1000),
           'stock' => $this->faker->numberBetween(0,    100),
           'image_url' => 'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
        ];
    }
}
