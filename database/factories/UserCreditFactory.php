<?php

use Faker\Generator as Faker;

$factory->define(App\UserCredit::class, function (Faker $faker) {
    $from = $faker->dateTimeBetween($startDate = '- 1 month', $endDate = '2018-12-20' );
    $fromStr = date_format($from, 'd.m.Y');
    $to = $faker->dateTimeBetween($startDate = "$fromStr + 5 days",$endDate = '2018-12-30' );
    $toStr = date_format($to, 'd.m.Y');
    return [
        'count' => $faker->numberBetween(5, 35),
        'removed_count' => $faker->numberBetween(0, 5),
        'valid_from' => $fromStr,
        'valid_to' =>  $toStr
        
    ];
});
