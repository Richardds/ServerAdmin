<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\Cron;

class CronsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cron::class, 10)->create();
    }
}
