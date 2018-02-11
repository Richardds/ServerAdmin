<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DnsZonesTableSeeder::class);
        $this->call(CronsTableSeeder::class);
        $this->call(MailDomainsTableSeeder::class);
        $this->call(MailUsersTableSeeder::class);
        $this->call(MailAliasesTableSeeder::class);
    }
}
