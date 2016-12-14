<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepients', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('mail')->unsigned();
            $table->foreign('mail')->references('id')->on('user_mails');
            $table->integer('receipient')->unsigned();
            $table->foreign('receipient')->references('id')->on('users');
            $table->integer('status')->unsigned();
            $table->foreign('status')->references('id')->on('available_message_status');
            $table->dateTime('read_on');
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
        Schema::dropIfExists('recepients');
    }
}
