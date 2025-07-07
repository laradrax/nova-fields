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

#### Basic Usage

```php
use Laradrax\Nova\Fields\ActionLinks;
use Laradrax\Nova\Fields\ActionIcon;
use Laradrax\Nova\Fields\ActionStyle;

ActionLinks::make('Actions')
    ->addLink(
        label: 'View Details',
        url: '/custom-view/' . $this->id,
        icon: ActionIcon::VIEW,
        style: ActionStyle::INFO,
        openInNewTab: true
    )
    ->addLink(
        label: 'Download PDF',
        url: '/download/' . $this->id,
        icon: ActionIcon::DOWNLOAD,
        style: ActionStyle::SUCCESS
    ),
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
    ->addView(ActionStyle::INFO, ActionIcon::VIEW, true)
    ->addEdit(ActionStyle::WARNING, ActionIcon::EDIT),

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
->addView(?ActionStyle $style, ?ActionIcon $icon, bool $openInNewTab = false)
->addEdit(?ActionStyle $style, ?ActionIcon $icon, bool $openInNewTab = false)
```

## Available Icons

The `ActionIcon` enum provides a wide range of SVG icons:

```php
ActionIcon::VIEW       // View
ActionIcon::EDIT       // Edit
ActionIcon::DELETE     // Delete
ActionIcon::USER       // User
ActionIcon::SETTINGS   // Settings
ActionIcon::DOWNLOAD   // Download
ActionIcon::CHART      // Chart
ActionIcon::SHOPPING_CART // Shopping Cart
ActionIcon::MAP_PIN    // Location
ActionIcon::SEARCH     // Search
ActionIcon::LINK       // Link
ActionIcon::BEAKER     // Laboratory
ActionIcon::CALENDAR   // Calendar
ActionIcon::CALL       // Call
ActionIcon::CODE       // Code
ActionIcon::DATABASE   // Database
ActionIcon::GLOBE      // Globe
ActionIcon::AI         // Artificial Intelligence
```

## Available Styles

The `ActionStyle` enum provides Tailwind CSS-based styles:

```php
ActionStyle::DEFAULT   // Gray
ActionStyle::SUCCESS   // Green
ActionStyle::WARNING   // Yellow
ActionStyle::DANGER    // Red
ActionStyle::INFO      // Blue
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
use Laradrax\Nova\Fields\ActionStyle;

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
                style: ActionStyle::INFO
            )
            ->addLink(
                label: 'Report',
                url: '/reports/' . $this->id,
                icon: ActionIcon::CHART,
                style: ActionStyle::SUCCESS,
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
            ->addView(ActionStyle::INFO, ActionIcon::VIEW, true)
            ->addEdit(ActionStyle::WARNING, ActionIcon::EDIT)
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