<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('access_codes')) {
            Schema::create('access_codes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('films')) {
            Schema::create('films', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('film_tags')) {
            Schema::create('film_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('film_id')->unsigned();
                $table->integer('tag_id')->unsigned();
                $table->unique(['film_id', 'tag_id']);
                $table->foreign('film_id')->references('id')->on('films');
                $table->foreign('tag_id')->references('id')->on('tags');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('category_tags')) {
            Schema::create('category_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->integer('tag_id')->unsigned();
                $table->unique(['category_id', 'tag_id']);
                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('tag_id')->references('id')->on('tags');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('votes')) {
            Schema::create('votes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->integer('film_id')->unsigned();
                $table->integer('access_code_id')->unsigned();
                $table->integer('weight')->nullable();
                $table->unique(['category_id', 'access_code_id']);
                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('film_id')->references('id')->on('films');
                $table->foreign('access_code_id')->references('id')->on('access_codes');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('category_access_codes')) {
            Schema::create('category_access_codes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->integer('access_code_id')->unsigned();
                $table->unique(['category_id', 'access_code_id']);
                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('access_code_id')->references('id')->on('access_codes');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_access_codes');
        Schema::dropIfExists('category_tags');
        Schema::dropIfExists('film_tags');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('films');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('access_codes');
    }
}
