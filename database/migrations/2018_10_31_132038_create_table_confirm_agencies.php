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
            $table->text('vacancy_ids');
            $table->integer('total_quiz');
            $table->integer('total_psychoTest');
            $table->string('promo_code')->nullable();
            $table->boolean('is_discount')->default(false);
            $table->string('discount')->nullable();
            $table->text('total_payment');
            $table->string('uni_code')->unique();
            $table->string('payment_type')->nullable();
            $table->string('payment_name')->nullable();
            $table->string('payment_number')->nullable();
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
