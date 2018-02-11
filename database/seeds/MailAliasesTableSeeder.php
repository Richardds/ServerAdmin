<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\MailAlias;

class MailAliasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MailAlias::class, 10)->create();
    }
}
