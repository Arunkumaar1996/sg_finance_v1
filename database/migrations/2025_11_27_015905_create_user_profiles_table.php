<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            // 1. Foreign Key linking to users table
            // constrained() automatically looks for 'users' table and 'id' column
            // onDelete('cascade') deletes the profile if the User is deleted
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Identification Details
            $table->string('uid')->unique()->nullable(); // Unique System Identifier
            $table->string('employee_id')->unique();     // The physical Employee Number (Merged emp_no here)
            $table->string('role')->default('Employee'); // Default role

            // 3. Personal Details
            $table->string('blood_group')->nullable();
            $table->date('dob')->nullable();

            // 4. Contact Details
            $table->string('contact_number'); // Made required (usually important)
            $table->string('emergency_contact_number')->nullable(); // Renamed for consistency

            // 5. Images (Stores file paths)
            $table->string('profile_image')->nullable(); // Path: img/profile/filename.jpg
            $table->string('barcode_image')->nullable(); // Path: img/barcodes/filename.png
            $table->string('qr_image')->nullable();
            // 6. System Fields
            $table->softDeletes(); // Adds deleted_at column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
