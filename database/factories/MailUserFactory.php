<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\MailUser;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(MailUser::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;

    return [
        'domain_id' => -1, // Must be overwritten by parent factory
        'name' => $firstName . ' ' . $lastName,
        'username' => strtolower($faker->asciify($firstName)) . '.' . strtolower($faker->asciify($lastName)),
        'password' => bcrypt('secret'),
    ];
});
