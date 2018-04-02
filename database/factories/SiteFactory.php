<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\Site;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Site::class, function (Faker $faker) {
    // TODO: SiteSSL support

    return [
        'name' => $faker->domainName,
        'php_enabled' => false, // TODO: PHP support
    ];
});
