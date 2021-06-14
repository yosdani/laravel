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
            $table->date('deadline')->nullable();
            $table->string('tags')->nullable();
            $table->string('description')->nullable();
            $table->string('attachedContent')->nullable();
            $table->string('dni')->nullable();
            $table->string('applicant')->nullable();
            $table->string('phone')->nullable();
            $table->string('centerEnrollment')->nullable();
            $table->integer('street_id')->unsigned()->nullable();
            $table->foreign('street_id')->references('id')->on('street')->onDelete('set null');
            $table->integer('district_id')->unsigned()->nullable();
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->integer('neighborhood_id')->unsigned()->nullable();
            $table->foreign('neighborhood_id')->references('id')->on('neighborhood')->onDelete('set null');
            $table->string('addressee')->nullable();
            $table->string('team')->nullable();
            $table->string('location');
            $table->string('responseForCitizen')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->integer('breakdown_id')->unsigned()->nullable();
            $table->foreign('breakdown_id')->references('id')->on('breakdown')->onDelete('set null');
            $table->integer('public_center_id')->unsigned()->nullable();
            $table->foreign('public_center_id')->references('id')->on('public_center')->onDelete('set null');

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
