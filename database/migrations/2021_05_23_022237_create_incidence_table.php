<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidence', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('assignedTo')->nullable();
            $table->string('reviewer')->nullable();
            $table->date('deadLine')->nullable();
            $table->date('creationDate')->nullable();
            $table->string('tags')->nullable();
            $table->string('description')->nullable();
            $table->string('attachedContentn')->nullable();
            $table->string('dni')->nullable();
            $table->string('applicant')->nullable();
            $table->string('phone')->nullable();
            $table->string('centerEnrollment');
            $table->string('streetNumber')->nullable();
            $table->string('district')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('addressee')->nullable();
            $table->string('team')->nullable();
            $table->string('location');
            $table->string('responseForCitizen');
            $table->integer('idUser')->unsigned()->nullable();
            $table->foreign('idUser')->references('id')->on('users');
            $table->integer('idState')->unsigned()->nullable();
            $table->foreign('idState')->references('id')->on('states');
            $table->integer('idBreakdown')->unsigned()->nullable();
            $table->foreign('idBreakdown')->references('id')->on('Breakdown');
            $table->integer('idPublicCenter')->unsigned()->nullable();
            $table->foreign('idPublicCenter')->references('id')->on('table_public_center');

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
        Schema::dropIfExists('incidence');
    }
}
