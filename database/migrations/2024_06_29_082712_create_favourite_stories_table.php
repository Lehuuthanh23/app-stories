<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouriteStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourite_stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 255);
            $table->unsignedBigInteger('story_id');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');

            // Đảm bảo rằng một người dùng không thể yêu thích cùng một câu chuyện nhiều lần
            $table->unique(['user_id', 'story_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourite_stories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['story_id']);
        });

        Schema::dropIfExists('favourite_stories');
    }
}
