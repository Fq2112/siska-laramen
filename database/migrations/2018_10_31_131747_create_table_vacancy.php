<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVacancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul', 200);
            $table->integer('agency_id')->unsigned();
            $table->foreign('agency_id')->references('id')->on('agencies')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('cities_id')->unsigned();
            $table->foreign('cities_id')->references('id')->on('cities')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('syarat');
            $table->text('tanggungjawab');
            $table->string('pengalaman');
            $table->integer('jobtype_id')->unsigned();
            $table->foreign('jobtype_id')->references('id')->on('job_types')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('industry_id')->unsigned();
            $table->foreign('industry_id')->references('id')->on('industris')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('joblevel_id')->unsigned();
            $table->foreign('joblevel_id')->references('id')->on('job_levels')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('salary_id')->unsigned();
            $table->foreign('salary_id')->references('id')->on('salaries')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('tingkatpend_id')->unsigned();
            $table->foreign('tingkatpend_id')->references('id')->on('tingkatpends')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('jurusanpend_id')->unsigned();
            $table->foreign('jurusanpend_id')->references('id')->on('jurusanpends')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('fungsikerja_id')->unsigned();
            $table->foreign('fungsikerja_id')->references('id')->on('fungsi_kerja')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('plan_id')->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('plans')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->decimal('passing_grade', 8, 2)->nullable();
            $table->integer('quiz_applicant')->nullable();
            $table->integer('psychoTest_applicant')->nullable();
            $table->boolean('isPost')->default(false);
            $table->date('active_period')->nullable();
            $table->date('recruitmentDate_start')->nullable();
            $table->date('recruitmentDate_end')->nullable();
            $table->date('quizDate_start')->nullable();
            $table->date('quizDate_end')->nullable();
            $table->date('psychoTestDate_start')->nullable();
            $table->date('psychoTestDate_end')->nullable();
            $table->date('interview_date')->nullable();
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
        Schema::dropIfExists('vacancy');
    }
}
