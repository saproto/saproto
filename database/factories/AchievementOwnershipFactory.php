<?php

use Faker\Generator as Faker;

/* @var $factory Closure */
$factory->define(
    Proto\Models\AchievementOwnership::class,
    function (Faker $faker, $attr) {
        $mintime = date('U', strtotime('-1 year'));
        $maxtime = date('U', strtotime('now'));

        $achievement= Proto\Models\Achievement::inRandomOrder()->first();

        $date = date('Y-m-d H:i:s', mt_rand($mintime, $maxtime));
        $alerted = mt_rand(0,1);

        return [
            'achievement_id' => $achievement->id,
            'created_at' => $date,
            'updated_at' => $date,
            'alerted' => $alerted
        ];
    }
);