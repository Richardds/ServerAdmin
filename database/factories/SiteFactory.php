<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\Site;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Site::class, function (Faker $faker) {
    // TODO: SSL support

    return [
        'name' => $faker->domainName,
        'enable_php' => false, // TODO: PHP support
    ];
});
