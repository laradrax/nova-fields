<?php

namespace Laradrax\Nova\Fields;

use InvalidArgumentException;
use Laravel\Nova\Fields\Field;

/**
 * Badge-style action links for Nova Resources with enhanced functionality.
 *
 * @method static static make(string|null $name)
 *
 * @phpstan-type Link array{
 *     url: string,
 *     label: string,
 *     icon: ActionIcon,
 *     style: ActionStyle,
 *     openInNewTab: bool
 * }
 */
class ActionLinks extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'action-links';

    /**
     * @var list<Link> Collection of action links
     */
    private array $links = [];

    /**
     * Create a new ResourceActionLinksField instance.
     *
     * @param  string|null  $name  The display name for the field (optional)
     *
     * @throws InvalidArgumentException If the resource class is invalid
     */
    public function __construct(
        ?string $name = null,
    ) {
        parent::__construct($name ?? __('Actions'));
    }

    /**
     * Add a link to the collection.
     */
    public function addLink(
        string $label,
        string $url,
        ?ActionIcon $icon = null,
        ?ActionStyle $style = null,
        bool $openInNewTab = false,
    ): static {
        $this->links[] = [
            'url' => $url,
            'label' => $label,
            'icon' => $icon ?? ActionIcon::LINK,
            'style' => $style ?? ActionStyle::DEFAULT,
            'openInNewTab' => $openInNewTab,
        ];

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'links' => $this->links,
        ]);
    }
}
