<?php

namespace Database\Factories;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Domain\Products\Models\Product\Product>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = sprintf('%s %s', 'Product', $this->faker->unique()->title);

        return [
            'uuid' => $this->faker->uuid,
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ];
    }
}
