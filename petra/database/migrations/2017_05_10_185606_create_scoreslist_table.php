<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreslistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores_list', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_user')->unsigned();
          $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
          $table->integer('id_point')->unsigned();
          $table->foreign('id_point')->references('id')->on('points')->onUpdate('cascade');
          $table->integer('id_review')->unsigned();
          $table->foreign('id_review')->references('id')->on('reviews')->onUpdate('cascade');
          $table->integer('score')->default(0);
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
        Schema::dropIfExists('scores_list');
    }
}
