<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    $dateOfCompletion = $faker->dateTimeBetween($startDate = 'now', $endDate = 'now + 14 days');
    $dateOfCompletionStr = date_format($dateOfCompletion,'d.m.Y');
    return [
        'title' => $faker->word(),
        'project' => $faker->word(),
        'content' => $faker->paragraph(6),
        'private_note' => $faker->paragraph(3),
        'type_id' => $faker->numberBetween(1,2),
        'state_id' => $faker->numberBetween(1,6),
        'credits_offer' => $faker->numberBetween(1,15),
        'date_of_completion_client' => $dateOfCompletionStr
    ];
});
