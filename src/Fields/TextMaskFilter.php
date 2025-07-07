<?php

namespace Laradrax\Nova\Fields;

use Laravel\Nova\Fields\Filters\Filter;

/**
 * Filter for TextMask field.
 *
 * Provides filtering functionality for TextMask fields in Laravel Nova.
 */
class TextMaskFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'text-mask';
}
