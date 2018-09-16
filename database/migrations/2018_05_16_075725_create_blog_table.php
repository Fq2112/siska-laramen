<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul',100);
            $table->string('subjudul',100)->nullable();
            $table->string('dir',200);
            $table->text('konten');
            $table->string('uploder',100);
            $table->integer('jenisblog_id')->unsigned();
            $table->foreign('jenisblog_id')->references('id')->on('jenisblog')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('blog');
    }
}
