<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToUserMails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_mails', function (Blueprint $table) {
          $table->integer('sender_status')->unsigned()->nullable();
          $table->foreign('sender_status')->references('id')->on('available_message_status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_mails', function (Blueprint $table) {
            $table->dropColumn('sender_status');
        });
    }
}
