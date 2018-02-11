<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\MailUser;

class MailUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MailUser::class, 10)->create();
    }
}
