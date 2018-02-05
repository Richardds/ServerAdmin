<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('domain_id');
            $table->string('username');
            $table->string('password');
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('mail_servers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_users');
    }
}
