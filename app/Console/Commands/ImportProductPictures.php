<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Proto\Models\Product;
use Proto\Models\StorageEntry;
use Proto\Models\User;

class ImportProductPictures extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:productpics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports all existing product pictures.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Product::all() as $product) {

            $this->info("Trying to download profile picture for " . $product->name . ".");

            $url = "http://utils.saproto.nl/static-legacy/food/" . $product->nicename . ".png";
            $headers = get_headers($url);
            if (substr($headers[0], 9, 3) != "200") {
                $this->error("Could not fetch profile picture for " . $product->name . ".");
                continue;
            }

            $file = new StorageEntry();
            $file->createFromData(file_get_contents($url), 'image/png', 'importedfoodpic-' . $product->id);

            $product->image()->associate($file);
            $product->save();

            $this->info("Profile picture downloaded for " . $product->name . "!");

        }
    }

}
