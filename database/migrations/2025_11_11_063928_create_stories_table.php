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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('category_id');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->json('story_images')->nullable();
            $table->string('author_name');
            $table->boolean('is_featured')->default(false);
            $table->integer('position')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
