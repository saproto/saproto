<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MoveMedia implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public HasMedia $model, public Media $media, public string $collection = 'default')
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->media->move($this->model, $this->collection);
    }
}
