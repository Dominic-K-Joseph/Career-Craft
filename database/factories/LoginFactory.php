<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Login;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Login>
 */
class LoginFactory extends Factory
{
     protected $model = Login::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'password' => bcrypt('123'), // default hashed password
            'role' => $this->faker->randomElement(['admin', 'seeker', 'employer']),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
