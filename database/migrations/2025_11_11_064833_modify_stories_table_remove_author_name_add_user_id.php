<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            if (Schema::hasColumn('stories', 'author_name')) {
                $table->dropColumn('author_name');
            }
            if (!Schema::hasColumn('stories', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('category_id');
            }
        });
        
        // Add foreign key separately if it doesn't exist
        Schema::table('stories', function (Blueprint $table) {
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'stories' AND COLUMN_NAME = 'user_id' AND CONSTRAINT_NAME != 'PRIMARY'");
            if (empty($foreignKeys)) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('author_name')->after('story_images');
        });
    }
};
