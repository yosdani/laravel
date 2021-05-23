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
            $table->string('name');
            $table->string('assignedTo');
            $table->string('reviewer');
            $table->date('deadLine');
            $table->date('creationDate');
            $table->string('tags')->nullable();
            $table->string('description')->nullable();
            $table->string('attachedContentn')->nullable();
            $table->string('dni');
            $table->string('applicant');
            $table->string('phone');
            $table->string('centerEnrollment');
            $table->string('streetNumber');
            $table->string('district');
            $table->string('neighborhood');
            $table->string('addressee');
            $table->string('team');
            $table->string('location');
            $table->string('responseForCitizen');
            $table->integer('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users');
            $table->integer('idState')->unsigned();
            $table->foreign('idState')->references('id')->on('states');
            $table->string('image')->nullable();

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
