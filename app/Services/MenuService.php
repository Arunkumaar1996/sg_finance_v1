<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class MenuService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getMenuItems()
    {
        $user = Auth::user();
        
        return collect([
            [
                'title' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'speedometer2',
                'permission' => 'view dashboard',
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'title' => 'Contact Submissions',
                'route' => 'admin.contact-submissions.index',
                'icon' => 'envelope-paper',
                'permission' => 'view contact submissions',
                'active' => request()->routeIs('admin.contact-submissions.*'),
                'badge' => function() {
                    return \App\Models\ContactSubmission::where('is_read', false)->count();
                }
            ],
            [
                'title' => 'Employee Management',
                'route' => 'employees.index',
                'icon' => 'people',
                'permission' => 'view employees',
                'active' => request()->routeIs('employees.*'),
            ],
            [
                'title' => 'Attendance',
                'route' => 'attendance.index',
                'icon' => 'calendar-check',
                'permission' => 'view attendance',
                'active' => request()->routeIs('attendance.*'),
            ],
            [
                'title' => 'Transactions',
                'route' => 'transactions.index',
                'icon' => 'cash-stack',
                'permission' => 'view transactions',
                'active' => request()->routeIs('transactions.*'),
            ],
            [
                'title' => 'Roles & Permissions',
                'route' => 'roles.index',
                'icon' => 'shield-check',
                'permission' => 'view roles',
                'active' => request()->routeIs('roles.*', 'permissions.*'),
            ],
            [
                'title' => 'My Profile',
                'route' => 'profile.show',
                'icon' => 'person-circle',
                'active' => request()->routeIs('profile.*'),
            ],
        ])->filter(function ($item) use ($user) {
            // Show item if it has no permission requirement or user has permission
            if (!isset($item['permission']) || !$item['permission']) {
                return true;
            }
            
            return $user && $user->can($item['permission']);
        });
    }
}
