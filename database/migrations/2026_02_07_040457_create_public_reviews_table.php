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
        Schema::create('public_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 rating
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_reviews');
    }
};
