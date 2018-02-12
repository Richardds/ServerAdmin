<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_aliases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('domain_id');
            $table->unsignedInteger('user_id');
            $table->string('alias');
            $table->timestamps();

            $table->unique(['domain_id', 'alias']);
            $table->foreign('domain_id')->references('id')->on('mail_domains')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('mail_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_aliases');
    }
}
