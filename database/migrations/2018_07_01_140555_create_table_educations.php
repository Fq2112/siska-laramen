<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEducations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seeker_id')->unsigned();
            $table->foreign('seeker_id')->references('id')->on('seekers')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('tingkatpend_id')->unsigned();
            $table->foreign('tingkatpend_id')->references('id')->on('tingkatpends')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('jurusanpend_id')->unsigned();
            $table->foreign('jurusanpend_id')->references('id')->on('jurusanpends')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('awards')->nullable();
            $table->string('school_name', 100)->nullable();
            $table->string('start_period', 4);
            $table->string('end_period', 4)->nullable();
            $table->string('nilai', 4)->nullable();
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
        Schema::dropIfExists('educations');
    }
}
