<?php

namespace Proto\Models;

use Artisan;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Proto\Models\Newsletter.
 *
 * @mixin Eloquent
 */
class Newsletter extends Model
{
    /** @return HashMapItem */
    public static function getLastSent()
    {
        $lastSent = HashMapItem::where('key', 'newsletter_last_sent')->first();
        if ($lastSent == null) {
            $lastSent = HashMapItem::create([
                'key' => 'newsletter_last_sent',
                'value' => 0,
            ]);
        }
        return $lastSent;
    }

    /** @return HashMapItem */
    public static function getText()
    {
        $lastSent = HashMapItem::where('key', 'newsletter_text')->first();
        if ($lastSent == null) {
            $lastSent = HashMapItem::create([
                'key' => 'newsletter_text',
                'value' => null,
            ]);
        }
        return $lastSent;
    }

    /** @return HashMapItem */
    public static function getTextLastUpdated()
    {
        $lastUpdated = HashMapItem::where('key', 'newsletter_text_updated')->first();
        if ($lastUpdated == null) {
            $lastUpdated = HashMapItem::create([
                'key' => 'newsletter_text_updated',
                'value' => 0,
            ]);
        }
        return $lastUpdated;
    }

    /** @return string */
    public static function lastSent()
    {
        return self::getLastSent()->value;
    }

    /** @return string */
    public static function text()
    {
        return self::getText()->value;
    }

    /** @return string */
    public static function textUpdated()
    {
        return self::getTextLastUpdated()->value;
    }

    /** @return string */
    public static function updateLastSent()
    {
        $lastSent = self::getLastSent();

        $lastSent->value = date('U');
        $lastSent->save();

        return $lastSent->value;
    }

    /** @return string */
    public static function updateText($text)
    {
        $newsletterText = self::getText();
        $textUpdated = self::getTextLastUpdated();

        $newsletterText->value = $text;
        $newsletterText->save();

        $textUpdated->value = date('U');
        $textUpdated->save();

        return $newsletterText->value;
    }

    /** @return bool */
    public static function canBeSent()
    {
        $lastSent = date('Y', self::lastSent()) * 52 + date('W', self::lastSent());
        $current = date('Y') * 52 + date('W');
        $events = Event::getEventsForNewsletter();
        return $current > $lastSent && $events->count() > 0;
    }

    /** @return bool */
    public static function showTextOnHomepage()
    {
        if (self::text() == '') {
            return false;
        }
        if ((date('U') - self::textUpdated()) / (3600 * 24) > 10) {
            return false;
        }
        return true;
    }

    /** @return bool */
    public static function send()
    {
        if (! self::canBeSent()) {
            return false;
        }
        Artisan::call('proto:newslettercron');
        self::updateLastSent();
        return true;
    }
}
