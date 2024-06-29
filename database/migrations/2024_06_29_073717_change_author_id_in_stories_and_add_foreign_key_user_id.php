<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAuthorIdInStoriesAndAddForeignKeyUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            // Ensure author_id is of the correct type
            $table->string('author_id', 255)->change();

            // Add foreign key constraint
            $table->foreign('author_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['author_id']);
        });
    }
}
