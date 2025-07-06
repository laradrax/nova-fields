<?php

namespace Laradrax\Nova\Fields;

/**
 * Enum for action types.
 */
enum ActionType: string
{
    case VIEW = 'view';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case RESTORE = 'restore';
    case REPLICATE = 'replicate';
    case CUSTOM = 'custom';
}
