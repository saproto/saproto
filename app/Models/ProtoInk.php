<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Feeds;
use Exception;

class ProtoInk extends Model
{
    /**
     * Returns ProtoInk Posts
     *
     * @return mixed
     */
    public static function getPostsFromFeed($max = null)
    {
        try {

            $feed = Feeds::make('https://proto.ink/feed');

            $data = [];
            foreach ($feed->get_items() as $item) {
                $data[] = (object)[
                    'title' => $item->get_title(),
                    'description' => $item->get_description(),
                    'link' => $item->get_permalink(),
                    'date' => $item->get_date('U'),
                    'thumbnail' => ProtoInk::extractThumbFromItem($item)
                ];
            }

            if ($max !== null) {
                return array_slice($data, 0, $max);
            } else {
                return $data;
            }

        } catch (Exception $e) {

            abort(500, "ProtoInk is not available. Please try again later.");

        }

    }

    public static function extractThumbFromItem($item)
    {
        try {
            $raw = (array)$item;
            return $raw['data']['child']['http://search.yahoo.com/mrss/']['content'][0]['attribs']['']['url'];
        } catch (Exception $e) {
            return asset('images/protoink-placeholder.png');
        }
    }

}
