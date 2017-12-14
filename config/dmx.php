<?php

return [

    /**
     * The array below defines which lecture types from the timetable should be considered a 'lecture',
     * where the SmartXp is really reserved and should be quiet. Any other type will result on 'tutorial' lights,
     * where people can work as long as they're relatively quiet. If there are no reservations, the free color will be used.
     */

    'lecture_types' => [
        'Lecture', 'Exam'
    ],

    /**
     * Red, Green, Blue, Brightness
     */

    'colors' => [
        'lecture' => [255, 40, 0],
        'tutorial' => [100, 0, 255],
        'free' => [0, 255, 0]
    ]

];