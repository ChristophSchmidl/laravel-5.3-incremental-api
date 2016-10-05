<?php

namespace App\Transformers;


class TagTransformer extends Transformer
{
    /**
     * @param $tag
     * @return array
     */
    public function transform($tag)
    {

        return [
            'name' => $tag['name'],
        ];

    }
}