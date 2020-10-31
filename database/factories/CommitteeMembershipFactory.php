<?php

use Faker\Generator as Faker;

/** @var $factory Closure */
$factory->define(Proto\Models\CommitteeMembership::class,
    function (Faker $faker, $attr) {
        $mintime = date('U', strtotime('-1 year'));
        $maxtime = date('U', strtotime('+1 year'));

        $date = [date('Y-m-d H:i:s', mt_rand($mintime, $maxtime)), date('Y-m-d H:i:s', mt_rand($mintime, $maxtime))];
        if ($date[0] < $date[1]) {
            $startDate = $date[0];
            $endDate = $date[1];
        } else {
            $startDate = $date[1];
            $endDate = $date[0];
        }

        return [
            'role' => 'Automatically Added',
            'edition' => (mt_rand(1, 2) == 1 ? mt_rand(1, 5) : null),
            'created_at' => $startDate,
            'deleted_at' => (mt_rand(1, 3) == 1 ? $endDate : null)
        ];
});
