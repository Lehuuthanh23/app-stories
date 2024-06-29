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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path')->default('')->notNullable();
            $table->unsignedBigInteger('story_id');
            $table->unsignedBigInteger('chapter_id');
            $table->boolean('is_cover_image')->default(false);
            $table->boolean('is_license_image')->default(false);
            $table->timestamps();

            // Thêm khóa ngoại
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');
            $table->foreign('chapter_id')->references('chapter_id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
