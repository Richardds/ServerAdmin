<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\MailDomain;

class MailDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MailDomain::class, 2)->create();
    }
}
