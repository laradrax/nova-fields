<?php

namespace Laradrax\Nova\Fields;

use InvalidArgumentException;
use Laravel\Nova\Fields\Field;

/**
 * Badge-style action links for Nova Resources with enhanced functionality.
 *
 * This field creates customizable action badges with icons and styling options.
 * Perfect for adding quick action buttons to your Nova resources with consistent
 * design and behavior.
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
     * The alignment of the action links.
     */
    private ActionAlign $align = ActionAlign::CENTER;

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
     * Set the alignment of the action links.
     *
     * @param  ActionAlign  $align  The alignment option for the action links
     * @return static The field instance for method chaining
     */
    public function align(ActionAlign $align): self
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Add a link to the collection.
     *
     * @param  string  $label  The display text for the link
     * @param  string  $url  The URL the link should navigate to
     * @param  ActionIcon|null  $icon  The icon to display (defaults to LINK icon)
     * @param  ActionStyle|null  $style  The styling for the link (defaults to DEFAULT style)
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return static The field instance for method chaining
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
     *
     * @return array<string, mixed> The serialized field data including all links
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'align' => $this->align->value,
            'links' => $this->links,
        ]);
    }
}
