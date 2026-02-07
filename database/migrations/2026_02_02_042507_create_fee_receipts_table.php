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
        Schema::create('fee_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('receipt_no'); // e.g., 'RCP-001', unique per school
            $table->decimal('amount', 10, 2);
            $table->enum('payment_mode', ['cash', 'online', 'cheque', 'upi'])->default('cash');
            $table->date('payment_date');
            $table->string('fee_month')->nullable(); // e.g., 'January 2026'
            $table->text('remarks')->nullable();
            $table->boolean('cancelled')->default(false);
            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');
            $table->timestamps();

            // Unique constraint on receipt_no per school
            $table->unique(['school_id', 'receipt_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_receipts');
    }
};
