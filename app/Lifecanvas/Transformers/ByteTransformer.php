<?php

namespace App\Lifecanvas\Transformers;


use App\Lifecanvas\Utilities\DateTimeUtilities;

class ByteTransformer extends Transformer
{
    public function transform($data)
    {
        $time = new DateTimeUtilities();
        $lines = [];
        $people = [];

        $count = count($data['lines']);
        if($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $lines[$x] = $data['lines'][$x]['name'];
            }
        }

        $count = count($data['people']);
        if($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $people[$x] = $data['people'][$x]['name'];
            }
        }

        $byte_date = ! is_null($data['byte_date']) ? $time->toLocalTime($data['byte_date'], $data['timezone']['timezone_name']) : null;

        return array(
            'id' => $data['id'],
            'name' => $data['name'],
            'story' => $data['story'],
            'favorite' => (boolean) $data['rating'],
            'rating' => $data['rating'],
            'privacy' => $data['privacy'],
            'byte_date_local' => $byte_date,
            'byte_date_utc' => $data['byte_date'],
            'accuracy' => $data['accuracy'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'image_id' => $data['image_id'],
            'place_name' => $data['place']['name'],
            'timezone_name' => $data['timezone']['timezone_name'],
            'linelines' => $lines,
            'people' => $people,
            'user' => $data['user']
        );
    }
}