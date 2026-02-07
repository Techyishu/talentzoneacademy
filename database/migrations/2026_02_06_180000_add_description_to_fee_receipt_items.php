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
        Schema::table('fee_receipt_items', function (Blueprint $table) {
            // Add description field for free-form fee entries
            $table->string('description')->nullable()->after('fee_head_id');

            // Make fee_head_id nullable (we'll drop the constraint and re-add as nullable)
            $table->dropForeign(['fee_head_id']);
            $table->foreignId('fee_head_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_receipt_items', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->foreignId('fee_head_id')->constrained()->change();
        });
    }
};
