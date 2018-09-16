<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seeker_id')->unsigned();
            $table->foreign('seeker_id')->references('id')->on('seekers')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name',40);
            $table->string('start_period', 4);
            $table->string('end_period', 4)->nullable();
            $table->string('title',60);
            $table->text('descript')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
