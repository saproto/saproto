<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    #[Override]
    public function definition(): array
    {
        return [
            'date_taken' => fake()->randomNumber(),
            'private' => false,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'album_id' => PhotoAlbum::factory(),
        ];
    }
}
