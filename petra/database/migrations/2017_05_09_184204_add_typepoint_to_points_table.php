<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypepointToPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->string('type_point');
            $table->text('description')->change();
            $table->float('latitude', 9, 6)->change();
            $table->float('longitude', 9, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            //
        });
    }
}
