<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public function definition(): array
    {
        return [
            "name"=> $this->faker->name,
            'email' =>$this->faker->unique()->safeEmail,
            "password"=> bcrypt('password'),
            "remember_token"=> Str::random(10),
        ];
    }
}

