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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->unsignedInteger('category_id');
            $table->string('film_poster')->nullable();
            $table->string('film_banner')->nullable();
            $table->date('release_date')->nullable();
            $table->string('watch_time')->nullable();
            $table->string('trailer_link')->nullable();
            $table->text('synopsis')->nullable();
            $table->json('genre')->nullable();
            $table->json('tags')->nullable();
            $table->text('description')->nullable();
            $table->string('watch_link')->nullable();
            $table->json('film_images')->nullable();
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
        Schema::dropIfExists('films');
    }
};

