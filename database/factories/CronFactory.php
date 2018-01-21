<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\Core\Cron\CronInterval;
use Richardds\ServerAdmin\Core\Cron\CronIntervalField;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Richardds\ServerAdmin\Cron::class, function (Faker $faker) {
    $intervalFields = [
        'Minute' => [0, 59],
        'Hour' => [0, 23],
        'Day' => [1, 31],
        'Month' => [1, 12],
        'Weekday' => [1, 7]
    ];
    $intervalFieldModifiers = ['Any', '', 'List', 'Step'];
    $intervalGenerator = function ($field) use ($faker, $intervalFields) {
        $min = $intervalFields[$field][0];
        $max = $intervalFields[$field][1];

        $from = $faker->numberBetween($min, $max - 1);
        $to = $faker->numberBetween($from + 1, $max);

        if ($faker->boolean((1/3)*100)) {
            return CronIntervalField::range($from, $to);
        }

        return CronIntervalField::single($from);
    };
    $intervalListGenerator = function ($field) use ($faker, $intervalFields, $intervalGenerator) {
        $count = $faker->numberBetween(2, 3);
        $list = [];

        for ($i = 0; $i < $count; $i++) {
            $list[] = $intervalGenerator($field);
        }

        return $list;
    };
    $stepGenerator = function ($field) use ($faker, $intervalFields) {
        $min = $intervalFields[$field][0];
        $max = $intervalFields[$field][1];

        return $faker->numberBetween($min + 1, floor($max / 2));
    };

    $interval = new CronInterval();

    $iterations = $faker->numberBetween(1, 3);
    for ($i = 0; $i < $iterations; $i++) {
        $field = $faker->randomElement(array_keys($intervalFields));
        $modifier = $faker->randomElement($intervalFieldModifiers);

        switch ($modifier) {
            case 'Any':
                $interval->{'set' . $field . $modifier}();
                break;
            case '':
                $interval->{'set' . $field . $modifier}($intervalGenerator($field));
                break;
            case 'List':
                $interval->{'set' . $field . $modifier}($intervalListGenerator($field));
                break;
            case 'Step':
                $interval->{'set' . $field . $modifier}($intervalGenerator($field), $stepGenerator($field));
                break;
        }
    }

    return [
        'minute' => $interval->getMinute(),
        'hour' => $interval->getHour(),
        'day' => $interval->getDay(),
        'month' => $interval->getMonth(),
        'weekday' => $interval->getWeekday(),
        'command' => $faker->randomElement([
            'ping -c ' . $faker->numberBetween(1, 5) . ' 127.0.0.1',
            'll ' . $faker->randomElement(['/', '/var', '/home']),
            'id',
            'groups root',
        ]),
        'uid' => $faker->numberBetween(0, 9),
    ];
});
