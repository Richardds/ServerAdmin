<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\User;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => 'secret',
    ];
});
