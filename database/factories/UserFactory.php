<?php

use Faker\Generator as Faker;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Richardds\ServerAdmin\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => $password = bcrypt('secret')
    ];
});
