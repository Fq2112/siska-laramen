<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychoTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psycho_test_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('psychoTest_id')->unsigned();
            $table->foreign('psychoTest_id')->references('id')->on('psycho_test_infos');
            $table->integer('seeker_id')->unsigned();
            $table->foreign('seeker_id')->references('id')->on('seekers');
            $table->integer('kompetensi');
            $table->integer('karakter');
            $table->integer('attitude');
            $table->integer('grooming');
            $table->integer('komunikasi');
            $table->integer('anthusiasme');
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');
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
        Schema::dropIfExists('psycho_test_results');
    }
}
