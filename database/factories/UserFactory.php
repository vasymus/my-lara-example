<?php

namespace Database\Factories;

use Domain\Users\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Domain\Users\Models\User\User>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-3 days');

        return [
            'name' => sprintf('%s %s', $this->faker->firstName(), $this->faker->lastName),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => '$2y$10$tfIw3I4Kbf4puFm0HEiCtOiiz45d6iGDOKf1d5GJECp6so1.mcX2y', // secret
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
