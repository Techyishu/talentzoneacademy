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
        Schema::create('homepage_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('video_url'); // YouTube/Vimeo URL or local file path
            $table->enum('video_type', ['youtube', 'vimeo', 'local'])->default('youtube');
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_videos');
    }
};
