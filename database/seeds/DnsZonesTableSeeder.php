<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\DnsRecord;
use Richardds\ServerAdmin\DnsZone;

class DnsZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DnsZone::class, 10)->create()->each(function (DnsZone $dnsZone) {
            factory(DnsRecord::class, 5)->create(['zone_id' => $dnsZone->id]);
        });
    }
}
