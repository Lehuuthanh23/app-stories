<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('comment_id');
            $table->string('user_id');
            $table->unsignedBigInteger('story_id')->nullable();
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->text('content');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');
            $table->foreign('chapter_id')->references('chapter_id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['story_id']);
            $table->dropForeign(['chapter_id']);
        });

        Schema::dropIfExists('comments');
    }
}
