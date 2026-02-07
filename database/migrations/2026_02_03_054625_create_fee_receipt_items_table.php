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
        Schema::create('fee_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_receipt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fee_head_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->index(['fee_receipt_id', 'fee_head_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_receipt_items');
    }
};
