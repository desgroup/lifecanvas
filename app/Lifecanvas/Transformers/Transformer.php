<?php

namespace App\Lifecanvas\Transformers;


abstract class Transformer {

    public function transformCollection(array $item)
    {
        return array_map([$this, 'transform'], $item);
    }

    public abstract function transform($item);

}