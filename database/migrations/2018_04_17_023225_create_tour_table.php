<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tentour');
            $table->integer('diadiem_id')->unsigned();
            $table->foreign('diadiem_id')->references('id')->on('diadiem')->onDelete('cascade');
            $table->tinyInteger('songaydi');
            $table->tinyInteger('sokhachtoida');
            $table->integer('giatour');
            $table->text('mota');
            $table->string('hinhanh')->nullable();
            $table->boolean('trangthaitour');
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
        Schema::dropIfExists('tour');
    }
}
