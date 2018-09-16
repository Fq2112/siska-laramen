<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('kantor_pusat', 60)->nullable();
            $table->integer('industri_id')->unsigned()->nullable();
            $table->foreign('industri_id')->references('id')->on('industris')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('tentang')->nullable();
            $table->text('alasan')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('phone')->nullable();
            $table->string('hari_kerja', 30)->nullable();
            $table->string('jam_kerja', 30)->nullable();
            $table->double('lat', 20, 10)->nullable();
            $table->double('long', 20, 10)->nullable();
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
        Schema::dropIfExists('agency');
    }
}
