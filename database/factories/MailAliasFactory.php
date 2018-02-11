<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\MailAlias;
use Richardds\ServerAdmin\MailDomain;
use Richardds\ServerAdmin\MailUser;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(MailAlias::class, function (Faker $faker) {
    $domains = MailDomain::all(['id'])->pluck('id')->toArray();
    $domainId = $faker->randomElement($domains);
    $users = MailUser::where('domain_id', '=', $domainId)->get(['id'])->pluck('id')->toArray();

    return [
        'domain_id' => $domainId,
        'user_id' => $faker->randomElement($users),
        'alias' => $faker->userName,
    ];
});
