<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Picqer\Barcode\BarcodeGeneratorPNG;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Barcode Directory Exists
        $path = public_path('img/barcodes');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $generator = new BarcodeGeneratorPNG();

        // ==========================================
        // CREATE SUPERADMIN
        // ==========================================
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@app.com',
            'password' => Hash::make('password'), // Default password
            'email_verified_at' => now(),
        ]);

        // Generate Barcode for Superadmin
        $saEmpId = 'SA-001';
        $saBarcodeName = 'barcode_' . $saEmpId . '.png';
        file_put_contents($path . '/' . $saBarcodeName, $generator->getBarcode($saEmpId, $generator::TYPE_CODE_128));

        UserProfile::create([
            'user_id' => $superAdmin->id,
            'uid' => uniqid('UID_'),
            'employee_id' => $saEmpId,
            'role' => 'Superadmin',
            'contact_number' => '9999999999', // Required field
            'emergency_contact_number' => '8888888888',
            'blood_group' => 'O+',
            'barcode_image' => $saBarcodeName,
            'dob' => '1990-01-01',
        ]);

        // ==========================================
        // CREATE ADMIN
        // ==========================================
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Generate Barcode for Admin
        $adEmpId = 'AD-001';
        $adBarcodeName = 'barcode_' . $adEmpId . '.png';
        file_put_contents($path . '/' . $adBarcodeName, $generator->getBarcode($adEmpId, $generator::TYPE_CODE_128));

        UserProfile::create([
            'user_id' => $admin->id,
            'uid' => uniqid('UID_'),
            'employee_id' => $adEmpId,
            'role' => 'Admin',
            'contact_number' => '7777777777', // Required field
            'emergency_contact_number' => '6666666666',
            'blood_group' => 'A+',
            'barcode_image' => $adBarcodeName,
            'dob' => '1995-05-05',
        ]);
    }
}