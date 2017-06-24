<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function(Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('middle_name')->nullable();
                $table->string('last_name');
                $table->string('email')->nullable();
                $table->unique(['first_name', 'middle_name', 'last_name']);
                $table->timestamps();
            });
        }

        Schema::table('access_codes', function(Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->after('code');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_codes', function(Blueprint $table) {
            $table->dropForeign('access_codes_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('users');
    }
}
