<?php

namespace Laradrax\Nova\Fields;

use InvalidArgumentException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource as NovaResource;

/**
 * Badge-style action links for Nova Resources with enhanced functionality.
 *
 * This field creates customizable action badges (view, edit, etc.) for related resources,
 * providing a clean and intuitive way to navigate between connected resources.
 *
 * @template TResource of NovaResource
 *
 * @method static static make(string $resource, int|string|null $key, string|null $name = null)
 *
 * @phpstan-type Link array{
 *     url: string,
 *     label: string,
 *     icon: ActionIcon,
 *     background: ActionStyle,
 *     openInNewTab: bool
 * }
 */
class ResourceActionLinks extends ActionLinks
{
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
     * @param  string  $resourceClass  The class name to validate
     *
     * @throws InvalidArgumentException If the class doesn't exist or isn't a Nova resource
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
     * @return static The field instance for method chaining
     */
    public function addAll(): static
    {
        return $this->addView()->addEdit();
    }

    /**
     * Add a "View" action link.
     *
     * @param  ActionStyle|null  $style  The styling for the link
     * @param  ActionIcon|null  $icon  The icon to use
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return static The field instance for method chaining
     */
    public function addView(
        ?ActionStyle $style = null,
        ?ActionIcon $icon = null,
        bool $openInNewTab = false,
    ): static {
        $url = Nova::url("{$this->resourceBasePath}/{$this->resourceKey}");
        $label = __('View').' '.$this->resourceSingular;

        $this->addLink(
            label: $label,
            url: $url,
            icon: $icon ?? ActionIcon::VIEW,
            style: $style ?? ActionStyle::DEFAULT,
            openInNewTab: $openInNewTab,
        );

        return $this;
    }

    /**
     * Add an "Edit" action link.
     *
     * @param  ActionStyle|null  $style  The styling for the link
     * @param  ActionIcon|null  $icon  The icon to use
     * @param  bool  $openInNewTab  Whether to open the link in a new tab
     * @return static The field instance for method chaining
     */
    public function addEdit(
        ?ActionStyle $style = null,
        ?ActionIcon $icon = null,
        bool $openInNewTab = false,
    ): static {
        $url = Nova::url("{$this->resourceBasePath}/{$this->resourceKey}/edit");
        $label = __('Edit').' '.$this->resourceSingular;

        $this->addLink(
            label: $label,
            url: $url,
            icon: $icon ?? ActionIcon::EDIT,
            style: $style ?? ActionStyle::DEFAULT,
            openInNewTab: $openInNewTab,
        );

        return $this;
    }
}
