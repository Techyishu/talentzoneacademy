<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the payment_mode enum to include 'card'
        DB::statement("ALTER TABLE fee_receipts MODIFY COLUMN payment_mode ENUM('cash', 'online', 'cheque', 'upi', 'card') DEFAULT 'cash'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE fee_receipts MODIFY COLUMN payment_mode ENUM('cash', 'online', 'cheque', 'upi') DEFAULT 'cash'");
    }
};
