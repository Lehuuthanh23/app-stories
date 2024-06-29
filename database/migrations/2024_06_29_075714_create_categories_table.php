<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
        
        // Sau khi tạo bảng categories, thêm cột category_id vào bảng stories
        Schema::table('stories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('active');
            
            // Thêm khóa ngoại
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa khóa ngoại trước khi xóa cột và bảng
        Schema::table('be_app_stories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
}
