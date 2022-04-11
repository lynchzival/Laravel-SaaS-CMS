<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRolesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> boolean('is_admin') -> after('profile_img') -> default(false);
            $table -> boolean('is_author') -> after('profile_img') -> default(false);
            $table -> boolean('is_reader') -> after('profile_img') -> default(false);
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
            $table -> dropColumn('is_admin');
            $table -> dropColumn('is_author');
            $table -> dropColumn('is_reader');
        });
    }
}
