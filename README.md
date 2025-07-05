# Text Mask for Laravel Nova

A Laravel Nova field package that provides input masking functionality using the powerful [Maska](https://github.com/beholdr/maska) library.

## Installation

Install the package via Composer:

```bash
composer require laradrax/text-mask
```

## Usage

Use the `TextMask` field in your Nova resources:

```php
use Laradrax\TextMask;

public function fields(NovaRequest $request)
{
    return [
        TextMask::make('Phone')
            ->mask('(###) ###-####'),
            
        TextMask::make('CPF')
            ->mask('###.###.###-##'),
            
        TextMask::make('Date')
            ->mask('##/##/####'),
    ];
}
```

## Configuration Options

### Basic Mask

Set a simple mask pattern:

```php
TextMask::make('Phone')
    ->mask('(###) ###-####')
```

### Custom Tokens

Define custom tokens for complex patterns:

```php
TextMask::make('Product Code')
    ->mask('LLL-###-LLL')
    ->tokens([
        'L' => ['pattern' => '[A-Z]', 'optional' => false],
    ])
```

### Eager Mode

Show static characters before typing (default: true):

```php
TextMask::make('Phone')
    ->mask('(###) ###-####')
    ->eager(true) // Shows "(" immediately
```

### Reversed Mode

Useful for numeric inputs that grow backwards:

```php
TextMask::make('Price')
    ->mask('$ #,##0.00')
    ->reversed(true)
```

### Raw Values

Send unmasked values to the server:

```php
TextMask::make('Phone')
    ->mask('(###) ###-####')
    ->raw(true) // Sends "1234567890" instead of "(123) 456-7890"
```

### Fill Required

Validate that the mask is completely filled:

```php
TextMask::make('Phone')
    ->mask('(###) ###-####')
    ->fillRequired(true) // Throws validation error if incomplete
```

## Mask Patterns

The package uses [Maska](https://github.com/beholdr/maska) default tokens:

- `#` - Any digit (0-9)
- `@` - Any letter (a-z, A-Z)
- `*` - Any alphanumeric character (letters & digits)

For additional patterns, you can define custom tokens using the `tokens()` method.

### Examples

```php
// Phone numbers
TextMask::make('Phone')->mask('(###) ###-####')

// Brazilian CPF
TextMask::make('CPF')->mask('###.###.###-##')

// Credit card
TextMask::make('Credit Card')->mask('#### #### #### ####')

// Date
TextMask::make('Date')->mask('##/##/####')

// Time
TextMask::make('Time')->mask('##:##')

// Postal code
TextMask::make('ZIP')->mask('#####-####')

// Name with letters only
TextMask::make('Name')->mask('@@@ @@@@@@@@@')

// Mixed alphanumeric code
TextMask::make('Code')->mask('***-***-***')
```

## Advanced Usage

### Dynamic Masks

You can use JSON arrays for dynamic masks:

```php
TextMask::make('Phone')
    ->mask('["(###) ###-####", "###-###-####"]')
```

### Complex Tokens

```php
TextMask::make('License Plate')
    ->mask('LLL-####')
    ->tokens([
        'L' => ['pattern' => '[A-Z]', 'optional' => false]
    ])
```

## Requirements

- PHP ^8.4
- Laravel Nova ^5.0
- Illuminate Support ^12.0
