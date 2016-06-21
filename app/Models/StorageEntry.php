<?php

namespace Proto\Models;

use Hash;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
}
