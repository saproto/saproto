<?php

namespace Proto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Artisan;

class Newsletter extends Model
{

    public static function getLastSent()
    {
        $lastSent = HashMapItem::where('key', 'newsletter_last_sent')->first();
        if ($lastSent == null) {
            $lastSent = HashMapItem::create([
                'key' => 'newsletter_last_sent',
                'value' => 0
            ]);
        }
        return $lastSent;
    }

    public static function getText()
    {
        $lastSent = HashMapItem::where('key', 'newsletter_text')->first();
        if ($lastSent == null) {
            $lastSent = HashMapItem::create([
                'key' => 'newsletter_text',
                'value' => null
            ]);
        }
        return $lastSent;
    }

    public static function getTextLastUpdated() {
        $lastUpdated = HashMapItem::where('key', 'newsletter_text_updated')->first();
        if ($lastUpdated == null) {
            $lastUpdated = HashMapItem::create([
                'key' => 'newsletter_text_updated',
                'value' => 0
            ]);
        }
        return $lastUpdated;
    }

    public static function lastSent()
    {
        return Newsletter::getLastSent()->value;
    }

    public static function text()
    {
        return Newsletter::getText()->value;
    }

    public static function textUpdated()
    {
        return Newsletter::getTextLastUpdated()->value;
    }

    public static function updateLastSent()
    {
        $lastSent = Newsletter::getLastSent();

        $lastSent->value = date('U');
        $lastSent->save();

        return $lastSent->value;
    }

    public static function updateText($text)
    {
        $newsletterText = Newsletter::getText();
        $textUpdated = Newsletter::getTextLastUpdated();

        $newsletterText->value = $text;
        $newsletterText->save();

        $textUpdated->value = date('U');
        $textUpdated->save();

        return $newsletterText->value;
    }

    public static function lastSentMoreThanWeekAgo()
    {
        $lastSent = Carbon::createFromFormat('U', Newsletter::lastSent());
        $current = Carbon::now();
        $diff = $lastSent->diffInWeeks($current);
        return $diff >= 1;
    }

    public static function hasEvents()
    {
        $events = Event::getEventsForNewsletter();
        return $events->count() > 0;
    }

    public static function showTextOnHomepage()
    {
        if (Newsletter::text() == "") return false;
        if ((date('U') - Newsletter::textUpdated())/(3600*24) > 10) return false;
        return true;
    }

    public static function send()
    {
        Artisan::call('proto:newslettercron');
        Newsletter::updateLastSent();
        return true;
    }

}
