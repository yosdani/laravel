<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenceImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidence_image', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->integer('idIncidence')->unsigned();
            $table->foreign('idIncidence')->references('id')->on('incidence');
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
        Schema::dropIfExists('incidence_image');
    }
}
