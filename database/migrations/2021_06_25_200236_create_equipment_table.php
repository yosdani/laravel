<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('incidence', function (Blueprint $table) {
            $table->integer('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->integer('equipment_id')->unsigned()->nullable();
            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->dropColumn('attachedContent');
            $table->dropColumn('applicant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
