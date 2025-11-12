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
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('vimeo_video_id')->nullable();
            $table->string('vimeo_title')->nullable();
            $table->text('vimeo_description')->nullable();
            $table->string('vimeo_button_text')->nullable();
            $table->string('vimeo_button_url')->nullable();
            $table->json('vimeo_film_ids')->nullable();
            $table->string('featured_story_banner_image')->nullable();
            $table->string('featured_story_title')->nullable();
            $table->text('featured_story_description')->nullable();
            $table->string('featured_story_button_text')->nullable();
            $table->string('featured_story_button_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};

