<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            ['name' => 'view_dashboard', 'description' => 'View Dashboard'],
            
            // Employee Management
            ['name' => 'view_employees', 'description' => 'View Employees'],
            ['name' => 'create_employees', 'description' => 'Create Employees'],
            ['name' => 'edit_employees', 'description' => 'Edit Employees'],
            ['name' => 'delete_employees', 'description' => 'Delete Employees'],
            
            // Role Management
            ['name' => 'view_roles', 'description' => 'View Roles'],
            ['name' => 'create_roles', 'description' => 'Create Roles'],
            ['name' => 'edit_roles', 'description' => 'Edit Roles'],
            ['name' => 'delete_roles', 'description' => 'Delete Roles'],
            
            // Attendance
            ['name' => 'view_attendance', 'description' => 'View Attendance'],
            ['name' => 'mark_attendance', 'description' => 'Mark Attendance'],
            ['name' => 'edit_attendance', 'description' => 'Edit Attendance'],
            
            // Reports
            ['name' => 'view_reports', 'description' => 'View Reports'],
            ['name' => 'generate_reports', 'description' => 'Generate Reports'],
            
            // Settings
            ['name' => 'manage_settings', 'description' => 'Manage System Settings'],
            
            // Profile
            ['name' => 'view_profile', 'description' => 'View Profile'],
            ['name' => 'edit_profile', 'description' => 'Edit Profile'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description']
            ]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'Administrator', 'description' => 'Full system access']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::create(['name' => 'Manager', 'description' => 'Department manager access']);
        $managerRole->givePermissionTo([
            'view_dashboard',
            'view_employees',
            'create_employees',
            'edit_employees',
            'view_attendance',
            'mark_attendance',
            'view_reports',
            'view_profile',
            'edit_profile'
        ]);

        $employeeRole = Role::create(['name' => 'Employee', 'description' => 'Basic employee access']);
        $employeeRole->givePermissionTo([
            'view_dashboard',
            'view_attendance',
            'view_profile',
            'edit_profile'
        ]);

        $hrRole = Role::create(['name' => 'HR Manager', 'description' => 'Human Resources manager']);
        $hrRole->givePermissionTo([
            'view_dashboard',
            'view_employees',
            'create_employees',
            'edit_employees',
            'view_attendance',
            'mark_attendance',
            'view_reports',
            'view_profile',
            'edit_profile'
        ]);
    }
}