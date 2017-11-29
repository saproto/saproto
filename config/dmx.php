<?php

return [

    /**
     * This config array identifies the DMX fixtures that should be automatically configured based on the timetable.
     *
     * The index in the array is the ID of the fixture that should be automatically controlled.
     * The value in the array is another array with the zero-based offsets of the channels for red, green, blue and brightness, resp.
     *
     * So, for example, for a fixture with ID 2 starting channel 10, RGB on channels 12, 11 and 10 and brightness on 13, you would write:
     * 2 => [2, 1, 0, 3]
     *
     * The automatic configuration only uses RGB and brightness. Any more advanced configuration should be configured manually via the website.
     */

    'preset_fixtures' => [
        4 => [0, 1, 2, 3],
        8 => [2, 3, 0, 1],
        6 => [0, 1, 2, 3],
        5 => [0, 1, 2, 3]
    ],

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
        'lecture' => [255, 40, 0, 255],
        'tutorial' => [100, 0, 255, 255],
        'free' => [0, 255, 0, 255]
    ]

];