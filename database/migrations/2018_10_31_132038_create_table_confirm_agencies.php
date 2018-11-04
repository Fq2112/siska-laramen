<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConfirmAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id')->unsigned();
            $table->foreign('agency_id')->references('id')->on('agencies')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('plans_id')->unsigned();
            $table->foreign('plans_id')->references('id')->on('plans')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('total_ads');
            $table->string('vacancy_ids');
            $table->integer('total_quiz');
            $table->integer('total_psychoTest');
            $table->integer('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_method')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('payment_code');
            $table->string('cc_number')->nullable();
            $table->string('cc_name')->nullable();
            $table->string('cc_expiry', '9')->nullable();
            $table->string('cc_cvc', '4')->nullable();
            $table->integer('total_payment');
            $table->text('payment_proof')->nullable();
            $table->boolean('isPaid')->default(false);
            $table->dateTime('date_payment')->nullable();
            $table->boolean('isAbort')->default(false);
            $table->boolean('isUpgrade')->default(false);
            $table->integer('from_plan')->nullable();
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('confirm_agencies');
    }
}
