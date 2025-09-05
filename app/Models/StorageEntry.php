<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Database\Factories\StorageEntryFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Override;

/**
 * Storage Entry Model.
 *
 * @property int $id
 * @property string $filename
 * @property string $mime
 * @property string $original_filename
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $hash
 *
 * @method static StorageEntryFactory factory($count = null, $state = [])
 * @method static Builder<static>|StorageEntry newModelQuery()
 * @method static Builder<static>|StorageEntry newQuery()
 * @method static Builder<static>|StorageEntry query()
 * @method static Builder<static>|StorageEntry whereCreatedAt($value)
 * @method static Builder<static>|StorageEntry whereFilename($value)
 * @method static Builder<static>|StorageEntry whereHash($value)
 * @method static Builder<static>|StorageEntry whereId($value)
 * @method static Builder<static>|StorageEntry whereMime($value)
 * @method static Builder<static>|StorageEntry whereOriginalFilename($value)
 * @method static Builder<static>|StorageEntry whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class StorageEntry extends Model
{
    /** @use HasFactory<StorageEntryFactory>*/
    use HasFactory;

    protected $table = 'files';

    protected $guarded = ['id'];

    /**
     * **IMPORTANT!** IF YOU ADD ANY RELATION TO A FILE IN ANOTHER MODEL, DON'T FORGET TO UPDATE THIS.
     *
     * @return bool whether or not the file is orphaned (not in use, can really be deleted safely)
     */
    public function isOrphan(): bool
    {
        return
            Page::query()->where('featured_image_id', $this->id)->count() == 0 &&
            DB::table('pages_files')->where('file_id', $this->id)->count() == 0 &&
            Member::withTrashed()->where('membership_form_id', $this->id)->count() == 0 &&
            DB::table('emails_files')->where('file_id', $this->id)->count() == 0 &&
            Newsitem::query()->where('featured_image_id', $this->id)->count() == 0 &&
            SoundboardSound::query()->where('file_id', $this->id)->count() == 0 &&
            HeaderImage::query()->where('image_id', $this->id)->count() == 0 &&
            Member::query()->where('omnomcom_sound_id', $this->id)->count() == 0 &&
            Sticker::query()->where('file_id', $this->id)->count() == 0;
    }

    /**
     * @throws FileNotFoundException
     */
    public function createFromFile(UploadedFile $file, ?string $customPath = null): void
    {
        $this->hash = $this->generateHash();

        $this->filename = Carbon::now()->format('Y\/F\/d').'/'.$this->hash;

        if (! empty($customPath)) {
            $this->filename = $customPath.$this->hash;
        }

        Storage::disk('local')->put($this->filename, $file);

        $this->mime = $file->getClientMimeType();
        $this->original_filename = $file->getClientOriginalName();

        $this->save();
    }

    public function createFromData(string $data, string $mime, string $name, ?string $customPath = null): void
    {
        $this->hash = $this->generateHash();
        $this->filename = Carbon::now()->format('Y\/F\/d').'/'.$this->hash;
        $this->mime = $mime;
        $this->original_filename = $name;

        if (! empty($customPath)) {
            $this->filename = $customPath.$this->hash;
        }

        Storage::disk('local')->put($this->filename, $data);

        $this->save();
    }

    private function generateHash(): string
    {
        return sha1(Carbon::now()->timestamp.mt_rand(1, 99999999999));
    }

    public function generatePath(): string
    {
        $url = route('file::get', ['id' => $this->id, 'hash' => $this->hash]);
        if (Config::get('app-proto.assets-domain') != null) {
            return str_replace(Config::string('app-proto.primary-domain'), Config::string('app-proto.assets-domain'), $url);
        }

        return $url;
    }

    public function generateImagePath(?int $w = null, ?int $h = null): string
    {
        $url = route('image::get', ['id' => $this->id, 'hash' => $this->hash, 'w' => $w, 'h' => $h]);
        if (Config::get('app-proto.assets-domain') != null) {
            return str_replace(Config::string('app-proto.primary-domain'), Config::string('app-proto.assets-domain'), $url);
        }

        return $url;
    }

    public function getBase64(?int $w = null, ?int $h = null): string
    {
        return base64_encode(FileController::makeImage($this, $w, $h));
    }

    /**
     * @param  bool  $human  Defaults to true.
     */
    public function getFileSize(bool $human = true): int|string
    {
        $size = File::size($this->generateLocalPath());
        if (! $human) {
            return $size;
        }

        if ($size < 1024) {
            return $size.' bytes';
        }

        if ($size < 1024 ** 2) {
            return round($size / 1024 ** 1, 1).' kilobytes';
        }

        if ($size < 1024 ** 3) {
            return round($size / 1024 ** 2, 1).' megabytes';
        }

        return round($size / 1024 ** 3, 1).' gigabytes';
    }

    public function generateLocalPath(): string
    {
        return Storage::disk('local')->path($this->filename);
    }

    /**
     * @param  string  $algo  Defaults to md5.
     */
    public function getFileHash(string $algo = 'md5'): string
    {
        return $algo.': '.hash_file($algo, $this->generateLocalPath());
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(static function ($file) {
            Storage::disk('local')->delete($file->filename);
        });
    }
}
