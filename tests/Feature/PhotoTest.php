<?php

use App\Models\Member;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

dataset('privacy_states', [
    'public' => false,
    'private' => true,
]);

it('uploads a photo to an unpublished album with correct custom path and disk, and moves it when made public or private', function (bool $private) {
    Storage::fake('public');
    Storage::fake('local');

    /** @var Member $member */
    $member = Member::factory()->create();
    $user = $member->user;
    $user->givePermissionTo('protography');

    $album = PhotoAlbum::factory()->create([
        'published' => false,
        'private' => $private,
    ]);

    $file = UploadedFile::fake()->image('photo.jpg');

    $response = $this->actingAs($user)->post(route('photo::admin::upload', ['id' => $album->id]), [
        'file' => $file,
    ]);

    $response->assertStatus(200);

    $photo = Photo::query()->where('album_id', $album->id)->first();
    $media = $photo->getFirstMedia();
    $hashedPath = md5($media->id.config('app.key'));
    $disk = $private ? 'local' : 'public';

    Storage::disk($disk)->assertExists("{$hashedPath}/{$media->file_name}");

    $response = $this->actingAs($user)->post(route('photo::admin::action', ['id' => $album->id]), [
        'action' => 'private',
        'photos' => [$photo->id],
    ]);

    $response->assertStatus(302);

    $photo->refresh();
    $media = $photo->getFirstMedia();
    $hashedPath = md5($media->id.config('app.key'));

    $newDisk = $private ? 'public' : 'local';

    Storage::disk($newDisk)->assertExists("{$hashedPath}/{$media->file_name}");
    Storage::disk($disk)->assertMissing("{$hashedPath}/{$media->file_name}");

})->with('privacy_states');
