<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreaIncidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidence', function (Blueprint $table) {
            $table->dropColumn('reviewer');
            $table->dropColumn('dni');
            $table->dropColumn('phone');
            $table->dropColumn('centerEnrollment');
            $table->dropColumn('assignedTo');
            $table->integer('assigned_id')->unsigned()->nullable();
            $table->foreign('assigned_id')->references('id')->on('users');
            $table->integer('area_id')->unsigned()->nullable();
            $table->foreign('area_id')->references('id')->on('area');
            $table->integer('enrolment_id')->unsigned()->nullable();
            $table->foreign('enrolment_id')->references('id')->on('enrolment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidences', function (Blueprint $table) {
            Schema::dropIfExists('incidences');
        });
    }
}
