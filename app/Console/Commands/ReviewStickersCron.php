<?php

namespace App\Console\Commands;

use App\Mail\ReviewStickersMail;
use App\Models\Sticker;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Description('Send the email to the board if there are reported stickers that need to be reviewed.')]
#[Signature('proto:reviewstickerscron')]
class ReviewStickersCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $reported = Sticker::query()->whereNotNull('reporter_id')->get();

        if ($reported->count() > 0) {
            $this->info('Sending an email to remind the board to review the stickers reported.');
            Mail::queue(new ReviewStickersMail($reported)->onQueue('low'));
        } else {
            $this->info('No new stickers reported which need to be checked today!');
        }
    }
}
