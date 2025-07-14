<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the "Teacher" role exists
        $teacherRole = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'web']);

        // Sample data for 10 teachers
        $teachers = [
            ['name' => 'Anita Sharma', 'email' => 'anita@gmail.com', 'subject' => 'Math'],
            ['name' => 'Ravi Mehta', 'email' => 'ravi@gmail.com', 'subject' => 'Science'],
            ['name' => 'Sneha Iyer', 'email' => 'sneha@gmail.com', 'subject' => 'English'],
            ['name' => 'Vikas Desai', 'email' => 'vikas@gmail.com', 'subject' => 'History'],
            ['name' => 'Nidhi Patel', 'email' => 'nidhi@gmail.com', 'subject' => 'Geography'],
            ['name' => 'Amit Kumar', 'email' => 'amit@gmail.com', 'subject' => 'Physics'],
            ['name' => 'Priya Verma', 'email' => 'priya@gmail.com', 'subject' => 'Biology'],
            ['name' => 'Rajeev Singh', 'email' => 'rajeev@gmail.com', 'subject' => 'Chemistry'],
            ['name' => 'Meena Joshi', 'email' => 'meena@gmail.com', 'subject' => 'Economics'],
            ['name' => 'Sunil Dubey', 'email' => 'sunil@gmail.com', 'subject' => 'Computer'],
        ];

        foreach ($teachers as $index => $data) {
            // Create user
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'), // default password
                ]
            );

            // Assign role
            $user->assignRole('Teacher');

            // Create teacher profile
            Teacher::firstOrCreate([
                'user_id'       => $user->id,
                'qualification' => 'B.Ed',
                'subject'       => $data['subject'],
                'phone'         => '98765' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'address'       => 'Address for ' . $data['name'],
                'profile_photo' => null,
                'joined_date'   => now()->subDays($index),
            ]);
        }
    }
}
