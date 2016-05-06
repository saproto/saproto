<?php

namespace Proto\Models;

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

    /**
     * This method initializes a StorageEntry object from a HTTP POST'ed file.
     * It fixes writing the file to the disk and seeding the object with the correct values for consistency. :)
     *
     * @param $postFile The file (must be from HTTP POST).
     */
    public function fillFrom($postFile)
    {
        $name = date('U') . "-" . mt_rand(1000, 9999);
        Storage::disk('local')->put($name, File::get($postFile));

        $this->mime = $postFile->getClientMimeType();
        $this->original_filename = $postFile->getClientOriginalName();
        $this->filename = $name;
    }

    /**
     * See fillForm, but also saves afterwards.
     *
     * @param $postFile The file (must be from HTTP POST).
     */
    public function createFrom($postFile)
    {
        $this->fillFrom($postFile);
        $this->save();
    }
}
