<?php

use Illuminate\Database\Seeder;
use Richardds\ServerAdmin\MailAlias;
use Richardds\ServerAdmin\MailDomain;
use Richardds\ServerAdmin\MailUser;

class MailDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MailDomain::class, 3)->create()->each(function (MailDomain $mailDomain) {
            factory(MailUser::class, 15)->create(['domain_id' => $mailDomain->id])
                ->each(function (MailUser $mailUser) use ($mailDomain) {
                    factory(MailAlias::class, 2)->create([
                        'domain_id' => $mailDomain->id,
                        'user_id' => $mailUser->id,
                    ]);
            });
        });
    }
}
