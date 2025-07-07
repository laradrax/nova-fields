<?php

namespace Laradrax\Nova\Fields;

/**
 * Enum for action alignment options.
 *
 * Provides predefined alignment options for action links.
 * These alignments can be used to control the positioning of action links within a Nova resource.
 */
enum ActionAlign: string
{
    case RIGHT = 'justify-start';
    case CENTER = 'justify-center';
    case LEFT = 'justify-end';
}
