<?php

use Faker\Generator as Faker;

$factory->define(Richardds\ServerAdmin\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'password' => $password = bcrypt('secret')
    ];
});
