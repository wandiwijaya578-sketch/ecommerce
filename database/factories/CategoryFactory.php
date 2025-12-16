<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(rand(1, 3), true)),
            'description' => $this->faker->optional()->paragraph,
            'image' => null, 
            'is_active' => $this->faker->boolean(90), 
        ];
    }


    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}

