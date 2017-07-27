<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2017-07-20
 * Time: 9:08 PM
 */

namespace App\Lifecanvas\Transformers;


class LineTransformer extends Transformer
{
    public function transform($data)
    {
        return array(
            'id' => $data['id'],
            'name' => $data['name']
        );
    }
}