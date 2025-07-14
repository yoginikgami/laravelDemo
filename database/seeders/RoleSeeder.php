<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $admin = Role::create(["name" => "Admin"]);
        // $teacher = Role::create(["name" => "Teacher"]);
        // $student = Role::create(["name" => "Student"]);

        // $admin = Role::findByName('Admin');
        // $admin->givePermissionTo(Permission::all());

        // $teacher = Role::findByName('Teacher');
        // $teacher->givePermissionTo(['view dashboard']);

        // $student = Role::findByName('Student');
        // $student->givePermissionTo(['view dashboard']);

        $permission = Permission::firstOrCreate([
            'name' => 'view dashboard',
            'guard_name' => 'web' // Make sure the guard is set
        ]);

        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $role->givePermissionTo('view dashboard');
    }
}
