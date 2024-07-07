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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('chapter_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('story_id')->nullable()->after('chapter_id');

            $table->foreign('chapter_id')->references('chapter_id')->on('chapters')->onDelete('cascade');
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['chapter_id']);
            $table->dropForeign(['story_id']);
            $table->dropColumn(['chapter_id', 'story_id']);
        });
    }
};
