<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age'); // Xóa cột age
            $table->date('birth_date')->after('password'); // Thêm cột birth_date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->unsigned()->after('password'); // Thêm lại cột age
            $table->dropColumn('birth_date'); // Xóa cột birth_date
        });
    }
}
