<?php

namespace Proto\Models;

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

    public static function lastSent()
    {
        return Newsletter::getLastSent()->value;
    }

    public static function updateLastSent()
    {
        $lastSent = Newsletter::getLastSent();

        $lastSent->value = date('U');
        $lastSent->save();

        return $lastSent->value;
    }

    public static function canBeSent()
    {
        $lastSent = date('Y', Newsletter::lastSent()) * 52 + date('W', Newsletter::lastSent());
        $current = date('Y') * 52 + date('W');
        return $current > $lastSent;
    }

    public static function send()
    {
        if (!Newsletter::canBeSent()) {
            return false;
        }
        Artisan::call('proto:newslettercron');
        Newsletter::updateLastSent();
        return true;
    }

}
