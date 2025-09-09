<?php

namespace App\Console\Commands;

use App\Models\Page;
use Exception;
use Illuminate\Console\Command;

class CopyPageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-page-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the page files from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Page::query()->whereHas('files')
            ->with('files')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($pages) use ($bar) {
            /** @var Page $page */
            foreach ($pages as $page) {
                foreach ($page->files as $file) {
                    try {
                        // check if the mime file is jpg, png or webp
                        $collection = 'files';
                        if (in_array($file->mime, ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
                            $collection = 'images';
                        }

                        $media = $page->addMedia($file->generateLocalPath())
                            ->usingName($file->original_filename)
                            ->preservingOriginal()
                            ->toMediaCollection($collection);

                        if($collection==='images' && $media){
                            $page->update([
                                'content'=> str_replace($file->generatePath(), $media->getFullUrl('large'), $page->content)
                            ]);
                        }else{
                            $page->update([
                                'content'=> str_replace($file->generatePath(), $media->getFullUrl(), $page->content)
                            ]);
                        }

                    } catch (Exception $e) {
                        $this->warn('Page: '.$page->id.' error: '.$e->getMessage());
                    }

//                    replace the link https://www.proto.utwente.nl/image/25747/c1939f2e28237ec2ec14eaa852e8c02d7e251cb6?w=1000
//                      with the new link $media-> $page->content
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
