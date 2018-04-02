<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\Site;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Site::class, 10)->create();
    }
}
