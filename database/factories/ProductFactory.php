<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product; 
use App\Models\Company;
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
            'product_name' => $this->faker->word,
            'company_id' => Company::factory(),
            'price' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(1, 100),
            'comment' => $this->faker->sentence,
            'img_path' => $this->faker->imageUrl(640, 480, 'products'),
        ];
    }
}
