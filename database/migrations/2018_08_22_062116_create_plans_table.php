<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price');
            $table->integer('discount')->length(3);
            $table->string('caption');
            $table->string('job_ads');
            $table->boolean('isQuiz')->default(false);
            $table->integer('quiz_applicant');
            $table->integer('price_quiz_applicant');
            $table->boolean('isPsychoTest')->default(false);
            $table->integer('psychoTest_applicant');
            $table->integer('price_psychoTest_applicant');
            $table->text('benefit');
            $table->boolean('isBest')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('plans');
    }
}
