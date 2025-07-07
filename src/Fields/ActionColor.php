<?php

namespace Laradrax\Nova\Fields;

/**
 * Enum for action styles (Tailwind CSS classes - Subset of Laravel Nova).
 *
 * Provides predefined styling options for action links using Tailwind CSS classes.
 * These styles ensure consistency with Laravel Nova's design system.
 */
enum ActionColor: string
{
    case DANGER = 'bg-red-50 text-red-700 ring-red-600/10';
    case WARNING = 'bg-yellow-100 text-yellow-800 ring-yellow-600/20';
    case SUCCESS = ' bg-green-100 text-green-700 ring-green-600/20';
    case INFO = 'bg-blue-100 text-blue-700 ring-blue-700/10';
    case DEFAULT = 'bg-gray-100 text-gray-600 ring-gray-500/10';
}
