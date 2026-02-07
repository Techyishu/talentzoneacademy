<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('staff_id')->nullable()->after('school_id')->constrained('staff')->nullOnDelete();
            $table->foreignId('student_id')->nullable()->after('staff_id')->constrained('students')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropForeign(['student_id']);
            $table->dropColumn(['staff_id', 'student_id']);
        });
    }
};
