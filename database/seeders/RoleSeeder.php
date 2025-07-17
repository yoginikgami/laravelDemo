<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $viewDashboard = Permission::firstOrCreate([
            'name' => 'view dashboard',
            'guard_name' => 'web'
        ]);

        $manageTeacher = Permission::firstOrCreate([
            'name' => 'manage teacher',
            'guard_name' => 'web'
        ]);

        $manageStudent = Permission::firstOrCreate([
            'name'=> 'manage student',
            'guard_name'=> 'web'
        ]);

        $manageClass = Permission::firstOrCreate([
            'name'=> 'manage school class',
            'guard_name'=> 'web'
        ]);

        $manageSubject = Permission::firstOrCreate([
            'name'=> 'manage subject',
            'guard_name'=> 'web'
        ]);

        // Create roles
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $teacherRole = Role::firstOrCreate([
            'name' => 'Teacher',
            'guard_name' => 'web'
        ]);

        $studentRole = Role::firstOrCreate([
            'name'=> 'Student',
            'guard_name'=> 'web'
        ]);


        $adminRole->givePermissionTo(Permission::all());
        $teacherRole->givePermissionTo([$viewDashboard, $manageStudent]);
        $studentRole->givePermissionTo([$viewDashboard]);

}
}
