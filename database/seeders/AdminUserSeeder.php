<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view dashboard',
            'manage students',
            'manage teacher',
            'manage school classes',
            'manage subjects',
        ];

        // Create permissions with guard
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create role with guard
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web']
        );

        // Assign all permissions to Admin
        $adminRole->syncPermissions(Permission::all());

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'rohan@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123'),
            ]
        );

        $admin->assignRole('Admin');
    }
}
