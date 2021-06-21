<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

<<<<<<< HEAD
class AlterContentNewsTable extends Migration
=======
<<<<<<< HEAD:database/migrations/2021_06_19_180948_add_fiters_user_table.php
class AddFitersUserTable extends Migration
=======
class AlterContentNewsTable extends Migration
>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2:database/migrations/2021_06_21_020012_alter_content_news_table.php
>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD
        Schema::table('news', function (Blueprint $table) {
            $table->longText('content')->change();

=======
<<<<<<< HEAD:database/migrations/2021_06_19_180948_add_fiters_user_table.php
        Schema::table('users', function (Blueprint $table) {
            $table->json('filters')->nullable();

            //
=======
        Schema::table('news', function (Blueprint $table) {
            $table->longText('content')->change();

>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2:database/migrations/2021_06_21_020012_alter_content_news_table.php
>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<< HEAD
        //
=======
<<<<<<< HEAD:database/migrations/2021_06_19_180948_add_fiters_user_table.php
        Schema::table('users', function (Blueprint $table) {
            //
        });
=======
        //
>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2:database/migrations/2021_06_21_020012_alter_content_news_table.php
>>>>>>> 4f4e576c6120568b89de762d9d89730a94119ec2
    }
}
