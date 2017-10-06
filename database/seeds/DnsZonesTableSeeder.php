<?php

use Illuminate\Database\Seeder;

class DnsZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Richardds\ServerAdmin\DnsZone::class, 10)->create();
    }
}
