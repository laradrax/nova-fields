<?php

namespace Laradrax\Nova\Fields;

/**
 * Enum for action icons with inline SVG support.
 */
enum ActionIcon: string
{
    case VIEW = <<<'SVG'
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5 mr-1 fill-current"
            viewBox="0 0 16 16"
            aria-hidden="true"
        >
            <path
                d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"
            />
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
            />
        </svg>
        SVG;

    case EDIT = <<<'SVG'
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5 mr-1 fill-current"
            viewBox="0 0 16 16"
            aria-hidden="true"
        >
            <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
            <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
        </svg>
        SVG;

    case DELETE = <<<'SVG'
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5 mr-1 fill-current"
            viewBox="0 0 16 16"
            aria-hidden="true"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.788l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.713Z"
            />
        </svg>
        SVG;

    case USER = <<<'SVG'
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5 mr-1 fill-current"
            viewBox="0 0 16 16"
            aria-hidden="true"
        >
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
        </svg>
        SVG;

    case DEFAULT = <<<'SVG'
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 h-3.5 mr-1 fill-current"
            viewBox="0 0 16 16"
            aria-hidden="true"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M4.22 11.78a.75.75 0 0 1 0-1.06L7.94 7 4.22 3.28a.75.75 0 0 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z"
            />
        </svg>
        SVG;
}
