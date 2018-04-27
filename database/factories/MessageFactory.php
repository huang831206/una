<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'device' => '6CED',
        'time' => ''.time(),
        'duplicate' => 0,
        'snr' => ''.$faker->randomFloat(2, 16.00, 19.00),
        'rssi' => '-126.00',
        'station' => '6D6C',
        'avgSnr' => ''.$faker->randomFloat(2, 17.00, 18.00),
        'lat' => $faker->latitude(25.04, 25.05).''.$faker->numberBetween(100000001, 999999999),
        'lng' => $faker->longitude(121.56, 121.57).''.$faker->numberBetween(100000001, 990999999),
        'radius' => $faker->numberBetween(10500, 10700),
        'geolocSource' => '2',
        'seqNumber' => \DB::table('messages')->max('seqNumber') + 1
    ];
});
