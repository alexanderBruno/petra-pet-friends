<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOndeleteIdreviewInLikereviewlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likereview_list', function (Blueprint $table) {
          $table->dropForeign('likereview_list_id_review_foreign');
          $table->foreign('id_review')->references('id')->on('reviews')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likereview_list', function (Blueprint $table) {
            //
        });
    }
}
