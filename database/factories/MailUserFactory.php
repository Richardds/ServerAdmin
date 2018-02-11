<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\MailDomain;
use Richardds\ServerAdmin\MailUser;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(MailUser::class, function (Faker $faker) {
    $domains = MailDomain::all('id')->pluck('id')->toArray();

    return [
        'domain_id' => $faker->randomElement($domains),
        'username' => strtolower($faker->asciify($faker->firstName)) . '.' . strtolower($faker->asciify($faker->lastName)),
        'password' => bcrypt('secret'),
    ];
});
