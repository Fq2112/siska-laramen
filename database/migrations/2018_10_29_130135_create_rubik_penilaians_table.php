<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubikPenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubik_penilaians', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->integer('kompetensi');
            $table->integer('karakter');
            $table->integer('attitude');
            $table->integer('grooming');
            $table->integer('komunikasi');
            $table->integer('anthusiasme');
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
        Schema::dropIfExists('rubik_penilaians');
    }
}
