<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOndeleteIdpostInLikepostslist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likeposts_list', function (Blueprint $table) {
          $table->dropForeign('likeposts_list_id_post_foreign');
          $table->foreign('id_post')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likeposts_list', function (Blueprint $table) {
            //
        });
    }
}
