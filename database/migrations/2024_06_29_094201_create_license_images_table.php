<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tạo bảng license_images mới
        Schema::create('license_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path', 255);
            $table->unsignedBigInteger('story_id')->nullable();
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('story_id')->references('story_id')->on('stories')->onDelete('cascade');
            $table->foreign('chapter_id')->references('chapter_id')->on('chapters')->onDelete('cascade');
        });

        // Cập nhật bảng images
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('is_license_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa bảng license_images nếu tồn tại
        Schema::dropIfExists('license_images');

        // Khôi phục lại cột is_license_image trong bảng images
        Schema::table('images', function (Blueprint $table) {
            $table->tinyInteger('is_license_image')->default(0);
        });
    }
}
