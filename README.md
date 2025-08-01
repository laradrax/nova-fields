# Nova Fields

A collection of custom fields for Laravel Nova that provides advanced functionality for your resources.

## Installation

You can install the package via Composer:

```bash
composer require laradrax/nova-fields
```

## Available Fields

### 1. TextMask

Text field with masking functionality using the Maska library.

#### Features

- ✅ Custom mask patterns support
- ✅ Customizable tokens
- ✅ Eager mode (shows static characters before typing)
- ✅ Reversed mode (useful for currency and numbers)
- ✅ Raw value (without mask) on submission
- ✅ Integrated filtering

#### Basic Usage

```php
use Laradrax\Nova\Fields\TextMask;

// Simple CPF mask
TextMask::make('CPF')
    ->mask('###.###.###-##'),

// Phone mask
TextMask::make('Phone')
    ->mask('(##) #####-####'),

// ZIP code mask
TextMask::make('ZIP')
    ->mask('#####-###'),
```

#### Available Methods

```php
// Set mask pattern
->mask('###.###.###-##')

// Custom tokens
->tokens([
    'X' => ['pattern' => '[0-9]', 'optional' => false],
    'Y' => ['pattern' => '[A-Z]', 'optional' => true]
])

// Eager mode (shows static characters)
->eager(true)

// Reversed mode (for numbers/currency)
->reversed(true)

// Raw value (without mask)
->raw(true)

// Require complete filling
->fillRequired(true)
```

#### Default Tokens

- `#` - Digit (0-9)
- `@` - Letter (a-z, A-Z)
- `*` - Alphanumeric

### 2. ActionLinks

Field that displays customizable action links with icons and styles.

#### Features

- ✅ Integrated SVG icons
- ✅ Predefined styles (colors)
- ✅ Open in new tab
- ✅ Customizable URLs
- ✅ Alignment options (left, center, right)

#### Basic Usage

```php
use Laradrax\Nova\Fields\ActionLinks;
use Laradrax\Nova\Fields\ActionIcon;
use Laradrax\Nova\Fields\ActionColor;
use Laradrax\Nova\Fields\ActionAlign;

ActionLinks::make('Actions')
    ->addLink(
        label: 'View Details',
        url: '/custom-view/' . $this->id,
        icon: ActionIcon::VIEW,
        color: ActionColor::INFO,
        openInNewTab: true
    )
    ->addLink(
        label: 'Download PDF',
        url: '/download/' . $this->id,
        icon: ActionIcon::DOWNLOAD,
        color: ActionColor::SUCCESS
    )
    ->align(ActionAlign::RIGHT),
```

### 3. ResourceActionLinks

Specialized field for Nova resource action links (view, edit, etc.).

#### Features

- ✅ Automatic integration with Nova resources
- ✅ Automatically generated URLs
- ✅ Resource class validation
- ✅ Convenient methods (addView, addEdit, addAll)

#### Basic Usage

```php
use Laradrax\Nova\Fields\ResourceActionLinks;
use App\Nova\User;

// Add all actions (view + edit)
ResourceActionLinks::make(User::class, $this->user_id)
    ->addAll(),

// Add specific actions
ResourceActionLinks::make(User::class, $this->user_id)
    ->addView(ActionIcon::VIEW, ActionColor::INFO, true)
    ->addEdit(ActionIcon::EDIT, ActionColor::WARNING),

// Customize field name
ResourceActionLinks::make(User::class, $this->user_id, 'User Actions')
    ->addView()
    ->addEdit(),
```

#### Available Methods

```php
// Add all default actions (view + edit)
->addAll()

// Standard Nova resource actions
->addView(?ActionIcon $icon, ?ActionColor $color, bool $openInNewTab = false)
->addEdit(?ActionIcon $icon, ?ActionColor $color, bool $openInNewTab = false)
```

## Available Icons

The `ActionIcon` enum provides a wide range of SVG icons:

```php
ActionIcon::AI         // Artificial Intelligence
ActionIcon::BEAKER     // Laboratory
ActionIcon::CALENDAR   // Calendar
ActionIcon::CALL       // Call
ActionIcon::CHART      // Chart
ActionIcon::CODE       // Code
ActionIcon::CREATE     // Create
ActionIcon::DATABASE   // Database
ActionIcon::DELETE     // Delete
ActionIcon::DOWNLOAD   // Download
ActionIcon::EDIT       // Edit
ActionIcon::FILTER     // Filter
ActionIcon::GLOBE      // Globe
ActionIcon::LINK       // Link
ActionIcon::MAP_PIN    // Location
ActionIcon::RELOAD     // Reload
ActionIcon::SEARCH     // Search
ActionIcon::SETTINGS   // Settings
ActionIcon::SHOPPING_CART // Shopping Cart
ActionIcon::USER       // User
ActionIcon::VIEW       // View
```

## Available Styles

The `ActionColor` enum provides Tailwind CSS-based styles:

```php
ActionColor::DEFAULT   // Gray
ActionColor::SUCCESS   // Green
ActionColor::WARNING   // Yellow
ActionColor::DANGER    // Red
ActionColor::INFO      // Blue
```

## Available Alignments

The `ActionAlign` enum provides alignment options for action links:

```php
ActionAlign::LEFT      // Left aligned
ActionAlign::CENTER    // Center aligned (default)
ActionAlign::RIGHT     // Right aligned
```

## Practical Examples

### Example 1: Registration Form

```php
use Laradrax\Nova\Fields\TextMask;

public function fields(Request $request)
{
    return [
        ID::make()->sortable(),
        
        Text::make('Name'),
        
        TextMask::make('CPF')
            ->mask('###.###.###-##')
            ->raw(true)
            ->fillRequired(true),
            
        TextMask::make('Phone')
            ->mask('(##) #####-####')
            ->raw(true),
            
        TextMask::make('ZIP Code')
            ->mask('#####-###')
            ->raw(true),
    ];
}
```

### Example 2: List with Actions

```php
use Laradrax\Nova\Fields\ActionLinks;
use Laradrax\Nova\Fields\ActionIcon;
use Laradrax\Nova\Fields\ActionColor;

public function fields(Request $request)
{
    return [
        ID::make()->sortable(),
        
        Text::make('Name'),
        
        ActionLinks::make('Actions')
            ->addLink(
                label: 'View Profile',
                url: '/profile/' . $this->id,
                icon: ActionIcon::USER,
                color: ActionColor::INFO
            )
            ->addLink(
                label: 'Report',
                url: '/reports/' . $this->id,
                icon: ActionIcon::CHART,
                color: ActionColor::SUCCESS,
                openInNewTab: true
            )
            ->onlyOnIndex(),
    ];
}
```

### Example 3: Relationships with Actions

```php
use Laradrax\Nova\Fields\ResourceActionLinks;
use App\Nova\User;

public function fields(Request $request)
{
    return [
        ID::make()->sortable(),
        
        Text::make('Title'),
        
        BelongsTo::make('User', 'user', User::class),
        
        ResourceActionLinks::make(User::class, $this->user_id, 'User Actions')
            ->addAll()
            ->onlyOnDetail(),
    ];
}
```

### Example 4: Custom Styled Actions

```php
use Laradrax\Nova\Fields\ResourceActionLinks;
use App\Nova\Product;

public function fields(Request $request)
{
    return [
        ID::make()->sortable(),
        
        Text::make('Name'),
        
        ResourceActionLinks::make(Product::class, $this->id, 'Product Actions')
            ->addView(ActionColor::INFO, ActionIcon::VIEW, true)
            ->addEdit(ActionColor::WARNING, ActionIcon::EDIT)
            ->onlyOnIndex(),
    ];
}
```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.

## License

This package is open-source software licensed under the [MIT License](LICENSE).

## Credits

- **Author**: Laradrax
- **Icons**: [Heroicons](https://heroicons.com/)
- **Mask Library**: [Maska](https://github.com/beholdr/maska)
