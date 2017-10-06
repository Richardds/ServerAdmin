<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnsZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 63);
            $table->string('admin', 253);
            $table->unsignedInteger('serial');
            $table->unsignedInteger('refresh');
            $table->unsignedInteger('retry');
            $table->unsignedInteger('expire');
            $table->unsignedInteger('ttl');
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
        Schema::dropIfExists('dns_zones');
    }
}
