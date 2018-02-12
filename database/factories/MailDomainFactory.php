<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\MailDomain;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(MailDomain::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
    ];
});
