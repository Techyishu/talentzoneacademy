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
            $table->enum('transaction_type', ['payment', 'adjustment'])->default('payment')->after('receipt_no');
            $table->foreignId('academic_session_id')->nullable()->after('school_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_receipts', function (Blueprint $table) {
            $table->dropForeign(['academic_session_id']);
            $table->dropColumn(['transaction_type', 'academic_session_id']);
        });
    }
};
