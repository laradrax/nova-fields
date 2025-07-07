<?php

namespace Laradrax\Nova\Fields;

use InvalidArgumentException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Resource as NovaResource;

/**
 * Badge-style action links for Nova Resources with enhanced functionality.
 *
 * This field creates customizable action badges (view, edit, etc.) for related resources,
 * providing a clean and intuitive way to navigate between connected resources.
 *
 * @template TResource of NovaResource
 *
 * @method static static make(string $resource, int|string|null $key)
 *
 * @phpstan-type Link array{
 *     type: ActionType,
 *     url: string,
 *     label: string,
 *     icon: ActionIcon,
 *     background: ActionStyle,
 *     openInNewTab: bool
 * }
 *
 * @example Basic usage:
 * ```php
 * ResourceActionLinksField::make('Actions', User::class, $this->user_id)
 *     ->addAll()
 *     ->onlyOnDetail();
 * ```
 * @example Advanced usage:
 * ```php
 * ResourceActionLinksField::make('User Actions', User::class, $this->user_id)
 *     ->addView(background: ActionStyle::SUCCESS)
 *     ->addEdit(background: ActionStyle::WARNING)
 *     ->addCustom('impersonate', 'Impersonate', '/custom-url', ActionIcon::USER)
 *     ->authorize(fn($request) => $request->user()->can('viewAny', User::class))
 *     ->openInNewTab();
 * ```
 */
class ResourceActionLinks extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'resource-action-links';

    /**
     * @var int|string|null The resource's primary key
     */
    private readonly int|string|null $resourceKey;

    /**
     * @var string The singular label of the resource
     */
    private readonly string $resourceSingular;

    /**
     * @var string The base URL path for the resource
     */
    private readonly string $resourceBasePath;

    /**
     * @var list<Link> Collection of action links
     */
    private array $links = [];

    /**
     * Create a new ResourceActionLinksField instance.
     *
     * @param  class-string<TResource>  $resource  The Nova resource class
     * @param  int|string|null  $key  The resource's primary key
     * @param  string|null  $name  The display name for the field (optional)
     *
     * @throws InvalidArgumentException If the resource class is invalid
     */
    public function __construct(
        string $resource,
        int|string|null $key,
        ?string $name = null,
    ) {
        parent::__construct($name ?? __('Actions'));

        $this->validateResourceClass($resource);

        $this->resourceKey = $key;
        $this->resourceSingular = $resource::singularLabel();
        $this->resourceBasePath = '/resources/'.$resource::uriKey();
    }

    /**
     * Validate that the provided class is a valid Nova resource.
     *
     *
     * @throws InvalidArgumentException
     */
    private function validateResourceClass(string $resourceClass): void
    {
        if (! class_exists($resourceClass)) {
            throw new InvalidArgumentException("Resource class [{$resourceClass}] does not exist");
        }

        if (! is_subclass_of($resourceClass, NovaResource::class)) {
            throw new InvalidArgumentException(
                "Class [{$resourceClass}] must extend ".NovaResource::class
            );
        }
    }

    /**
     * Add all standard actions (view and edit).
     *
     * @return $this
     */
    public function addAll(): static
    {
        return $this
            ->addView()
            ->addEdit();
    }

    /**
     * Add a "View" action link.
     *
     * @param  ActionStyle|null  $background  The background style
     * @param  ActionIcon|null  $icon  The icon to use
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return $this
     */
    public function addView(
        ?ActionStyle $background = null,
        ?ActionIcon $icon = null,
        bool $openInNewTab = false,
    ): static {
        $url = "{$this->resourceBasePath}/{$this->resourceKey}";
        $label = __('View').' '.$this->resourceSingular;

        $this->addLink(
            type: ActionType::VIEW,
            label: $label,
            url: $url,
            icon: $icon ?? ActionIcon::VIEW,
            background: $background ?? ActionStyle::DEFAULT,
            openInNewTab: $openInNewTab,
        );

        return $this;
    }

    /**
     * Add an "Edit" action link.
     *
     * @param  ActionStyle|null  $background  The background style
     * @param  ActionIcon|null  $icon  The icon to use
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return $this
     */
    public function addEdit(
        ?ActionStyle $background = null,
        ?ActionIcon $icon = null,
        bool $openInNewTab = false,
    ): static {
        $url = "{$this->resourceBasePath}/{$this->resourceKey}/edit";
        $label = __('Edit').' '.$this->resourceSingular;

        $this->addLink(
            type: ActionType::EDIT,
            label: $label,
            url: $url,
            icon: $icon ?? ActionIcon::EDIT,
            background: $background ?? ActionStyle::DEFAULT,
            openInNewTab: $openInNewTab,
        );

        return $this;
    }

    /**
     * Add a custom action link.
     *
     * @param  string  $label  Display label for the action
     * @param  string  $url  The URL for the action (relative or absolute)
     * @param  ActionIcon|null  $icon  The icon to use
     * @param  ActionStyle|null  $background  The background style
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return $this
     */
    public function addCustom(
        string $label,
        string $url,
        ?ActionIcon $icon = null,
        ?ActionStyle $background = null,
        bool $openInNewTab = false,
    ): static {
        $this->addLink(
            type: ActionType::CUSTOM,
            label: $label,
            url: $url,
            icon: $icon ?? ActionIcon::LINK,
            background: $background ?? ActionStyle::DEFAULT,
            openInNewTab: $openInNewTab,
        );

        return $this;
    }

    /**
     * Add a link to the collection.
     */
    private function addLink(
        ActionType $type,
        string $label,
        string $url,
        ?ActionIcon $icon = null,
        ?ActionStyle $background = null,
        bool $openInNewTab = false,
    ): void {
        $this->links[] = [
            'type' => $type,
            'url' => $url,
            'label' => $label,
            'icon' => $icon ?? ActionIcon::LINK,
            'background' => $background ?? ActionStyle::DEFAULT,
            'openInNewTab' => $openInNewTab,
        ];
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
