<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role enum to include 'parent'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'school_admin', 'staff', 'student', 'parent') NOT NULL DEFAULT 'school_admin'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'parent' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'school_admin', 'staff', 'student') NOT NULL DEFAULT 'school_admin'");
    }
};
