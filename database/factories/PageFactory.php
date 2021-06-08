<?php

use Faker\Generator as Faker;

/** @var $factory Closure */
$factory->define(Proto\Models\Page::class,
    function (Faker $faker) {
        return [
            'title' => $faker->words(mt_rand(1, 3), true),
            'slug' => $faker->unique()->word(),
            'content' => $faker->paragraphs(10, true),
            'is_member_only' => mt_rand(0, 1),
            'featured_image_id' => null,
            'show_attachments' => false
        ];
    });
