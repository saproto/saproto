<?php

namespace Proto\Models;

use Hash;
use DB;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Proto\Http\Controllers\FileController;

use Proto\Models\Company;
use Proto\Models\NarrowcastingItem;
use Proto\Models\Page;
use Proto\Models\Product;

class StorageEntry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    public function createFromFile($file)
    {

        $this->hash = $this->generateHash();

        $this->filename = date('Y\/F\/d') . '/' . $this->hash;

        Storage::disk('local')->put($this->filename, File::get($file));

        $this->mime = $file->getClientMimeType();
        $this->original_filename = $file->getClientOriginalName();

        $this->save();

    }

    public function createFromData($data, $mime, $name)
    {

        $this->hash = $this->generateHash();

        $this->filename = date('Y\/F\/d') . '/' . $this->hash;

        Storage::disk('local')->put($this->filename, $data);

        $this->mime = $mime;
        $this->original_filename = $name;

        $this->save();

    }

    private function generateHash()
    {
        return sha1(date('U') . mt_rand(1, 99999999999));
    }

    public function generatePath()
    {
        return route('file::get', ['id' => $this->id, 'hash' => $this->hash, 'name' => $this->original_filename]);
    }

    public function generateImagePath($w, $h)
    {
        return route('image::get', ['id' => $this->id, 'hash' => $this->hash, 'name' => $this->original_filename, 'w' => $w, 'h' => $h]);
    }

    public function getBase64($w = null, $h = null)
    {
        return base64_encode(FileController::makeImage($this, $w, $h));
    }

    public function getFileSize($human = true)
    {
        $size = File::size($this->generateLocalPath());
        if ($human) {
            if ($size < 1024) {
                return $size . ' bytes';
            } elseif ($size < pow(1024, 2)) {
                return round($size / pow(1024, 1), 1) . ' kilobytes';
            } elseif ($size < pow(1024, 3)) {
                return round($size / pow(1024, 2), 1) . ' megabytes';
            } else {
                return round($size / pow(1024, 3), 1) . ' gigabytes';
            }
        } else {
            return $size;
        }
    }

    public function generateLocalPath()
    {
        return storage_path('app/' . $this->filename);
    }

    public function getFileHash($algo = 'md5')
    {
        return $algo . ': ' . hash_file($algo, $this->generateLocalPath());
    }

    public function isOrphan()
    {
        $id = $this->id;
        return NarrowcastingItem::where('image_id', $id)->count() == 0 &&
            Page::where('featured_image_id', $id)->count() == 0 &&
            DB::table('pages_files')->where('file_id', $id)->count() == 0 &&
            Product::where('image_id', $id)->count() == 0 &&
            Company::where('image_id', $id)->count() == 0 &&
            User::where('image_id', $id)->count() == 0 &&
            DB::table('emails_files')->where('file_id', $id)->count() == 0 &&
            Committee::where('image_id', $id)->count() == 0 &&
            Event::where('image_id', $id)->count() == 0;
    }
}
