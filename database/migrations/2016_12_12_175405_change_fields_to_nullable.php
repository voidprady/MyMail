<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_mails', function (Blueprint $table) {
            $table->bigInteger('child_of')->nullable()->change();
            $table->string('text')->nullable()->change();
            $table->string('body')->nullable()->change();
            $table->binary('attachment')->nullable()->change();
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
            //
        });
    }
}
