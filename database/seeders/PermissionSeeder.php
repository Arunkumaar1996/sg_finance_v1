<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',
            
            // Contact Submissions
            'view contact submissions',
            'edit contact submissions',
            'delete contact submissions',
            
            // Employee Management
            'view employees',
            'create employees',
            'edit employees',
            'delete employees',
            
            // Attendance
            'view attendance',
            'create attendance',
            'edit attendance',
            'delete attendance',
            'approve attendance',
            
            // Transactions
            'view transactions',
            'create transactions',
            'edit transactions',
            'delete transactions',
            'approve transactions',
            
            // Roles & Permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'assign roles',
            
            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Reports
            'view reports',
            'generate reports',
            
            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view dashboard',
            'view contact submissions',
            'view employees',
            'create employees',
            'edit employees',
            'view attendance',
            'approve attendance',
            'view transactions',
            'create transactions',
            'view reports',
            'generate reports',
        ]);

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view dashboard',
            'view attendance',
            'create attendance', // For check-in/check-out
            'view transactions',
        ]);

        // Create a super admin user (optional)
        $user = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');
    }
}
