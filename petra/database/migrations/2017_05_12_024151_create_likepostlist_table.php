<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikepostlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likeposts_list', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_user')->unsigned();
          $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
          $table->integer('id_post')->unsigned();
          $table->foreign('id_post')->references('id')->on('posts')->onUpdate('cascade');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likeposts_list');
    }
}
