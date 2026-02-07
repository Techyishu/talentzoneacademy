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
        Schema::table('students', function (Blueprint $table) {
            // Add new foreign key columns
            $table->foreignId('class_id')->nullable()->after('dob')->constrained();
            $table->foreignId('section_id')->nullable()->after('class_id')->constrained();

            // Rename old text fields as backup
            $table->string('class_old')->nullable()->after('section_id');
            $table->string('section_old')->nullable()->after('class_old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn(['class_id', 'section_id', 'class_old', 'section_old']);
        });
    }
};
