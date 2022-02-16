<?php

namespace Database\Factories;

use Domain\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Domain\Orders\Models\Order>
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-3 days');

        return [
            'comment_user' => $this->faker->text(30),
            'comment_admin' => $this->faker->text(30),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
