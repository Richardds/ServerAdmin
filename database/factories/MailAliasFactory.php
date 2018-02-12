<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\MailAlias;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(MailAlias::class, function (Faker $faker) {
    return [
        'domain_id' => 1, // Must be overwritten by parent factory
        'user_id' => 1, // Must be overwritten by parent factory
        'alias' => $faker->userName,
    ];
});
