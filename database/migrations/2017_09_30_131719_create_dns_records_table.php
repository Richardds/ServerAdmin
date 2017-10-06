<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Richardds\ServerAdmin\DnsRecord;

class CreateDnsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('zone_id');
            $table->enum('type', DnsRecord::availableTypes());
            $table->string('name');
            $table->string('value');
            $table->unsignedInteger('ttl');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('zone_id')->references('id')->on('dns_zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dns_records');
    }
}
