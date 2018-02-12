<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\DnsZone;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(DnsZone::class, function (Faker $faker) {
    $name = $faker->domainName;

    return [
        'name' => $name,
        'admin' => 'admin.'.$name,
        'serial' => intval($faker->year . $faker->month . $faker->dayOfMonth),
        'refresh' => $faker->numberBetween(1, 8) * 60 * 60 * 6, // 6, 12, 18 hours ...
        'retry' => $faker->numberBetween(1, 8) * 60 * 30, // 30, 60, 90 minutes ...
        'expire' => $faker->numberBetween(1, 4) * 60 * 60 * 600, // 600, 1200, 1800 hours ...
        'ttl' => $faker->numberBetween(1, 8) * 60 * 60 * 12, // 12, 24, 36 hours ...
    ];
});
