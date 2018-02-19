<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirewallRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['allow', 'deny', 'reject', 'limit']);
            $table->enum('protocol', ['tcp', 'udp']);
            $table->string('destination', 44)->nullable();
            $table->string('source', 44)->nullable();
            $table->unsignedSmallInteger('port');
            $table->unsignedSmallInteger('portTo')->nullable();
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('firewall_rules');
    }
}
