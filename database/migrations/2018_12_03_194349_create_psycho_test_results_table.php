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
            $table->foreign('psychoTest_id')->references('id')->on('psycho_test_infos')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('seeker_id')->unsigned();
            $table->foreign('seeker_id')->references('id')->on('seekers')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->decimal('kompetensi', 8,2);
            $table->decimal('karakter', 8,2);
            $table->decimal('attitude', 8,2);
            $table->decimal('grooming', 8,2);
            $table->decimal('komunikasi', 8,2);
            $table->decimal('anthusiasme', 8,2);
            $table->text('note')->nullable();
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
