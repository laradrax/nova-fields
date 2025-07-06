<?php

namespace Laradrax\Nova\Fields;

/**
 * Enum for action styles (Tailwind CSS classes).
 */
enum ActionStyle: string
{
    case PRIMARY = 'bg-primary-500 text-white';
    case SUCCESS = 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300';
    case WARNING = 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300';
    case DANGER = 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300';
    case INFO = 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300';
    case SECONDARY = 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300';
    case DEFAULT = 'bg-primary-50 dark:bg-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500';
}
