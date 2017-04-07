<?php

namespace Mpchadwick\SearchAutocompleteConfigmarator\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Likematchposition implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'start', 'label' => __('Start')],
            ['value' => 'any', 'label' => __('Any')],
        ];
    }
}
