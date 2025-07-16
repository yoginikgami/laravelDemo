<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class teacherFactory extends Factory
{
    protected $model = Teacher::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'qualification' => $this->faker->randomElement(['B.Ed','M.Ed', 'Ph.D', 'M.Sc', 'MCA']),
            'subject'=> $this->faker->randomElement(['Hindi','Gujarati', 'English', 'Science', 'Social Science', 'Math', 'Computer']),
            'phone'=> $this->faker->phoneNumber,
            'address'=> $this->faker->address,
            'profile_photo'=> null,
            'joined_date' => $this->faker->date(),

        ];
    }
}
