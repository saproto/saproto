<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PhotoAlbumFactory extends Factory
{
    protected $model = PhotoAlbum::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'date_create' => $this->faker->randomNumber(),
            'date_taken' => $this->faker->randomNumber(),
            'thumb_id' => 0,
            'private' => $this->faker->boolean(),
            'published' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'event_id' => Event::factory(),
        ];
    }
}
