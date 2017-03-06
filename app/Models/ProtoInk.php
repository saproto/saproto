<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

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

            $xml = simplexml_load_string(file_get_contents("http://proto.ink/feed/"));

            // dd($posts->attributes('item', 1));

            $data = [];
            foreach ($xml->channel->item as $item) {
                $data[] = (object)[
                    'title' => (string)$item->title,
                    'description' => (string)$item->description,
                ];
                // dd($item->description);
            }

            return $data;

        } catch (Exception $e) {

            abort(500, "ProtoInk is not available. Please try again later.");

        }

    }

}
