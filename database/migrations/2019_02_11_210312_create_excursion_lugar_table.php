<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcursionLugarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_lugar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excursion_id')->unsigned();
            $table->integer('lugar_id')->unsigned();

            $table->foreign('excursion_id')->references('id')->on('excursion')->onDelete('cascade')->change();;
            $table->foreign('lugar_id')->references('id')->on('lugar')->onDelete('cascade')->change();;
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
        Schema::dropIfExists('excursion_lugar');
    }
}
