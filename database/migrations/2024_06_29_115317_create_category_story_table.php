<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_story', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('story_id');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');

            $table->unique(['category_id', 'story_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_story');
    }
}
