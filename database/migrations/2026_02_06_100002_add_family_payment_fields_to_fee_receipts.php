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
        Schema::table('fee_receipts', function (Blueprint $table) {
            $table->enum('payment_type', ['student', 'family'])->default('student')->after('transaction_type');
            $table->foreignId('parent_user_id')->nullable()->after('student_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_receipts', function (Blueprint $table) {
            $table->dropForeign(['parent_user_id']);
            $table->dropColumn(['payment_type', 'parent_user_id']);
        });
    }
};
