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
        Schema::create('family_payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_receipt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->decimal('allocated_amount', 10, 2);
            $table->enum('allocation_method', ['proportional', 'manual'])->default('proportional');
            $table->timestamps();

            // Indexes for queries
            $table->index('fee_receipt_id');
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_payment_allocations');
    }
};
