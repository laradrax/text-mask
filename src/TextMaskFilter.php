<?php

namespace Laradrax\TextMask;

use Laravel\Nova\Fields\Filters\Filter;

class TextMaskFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'text-mask';
}
