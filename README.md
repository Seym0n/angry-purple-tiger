# Angry Purple Tiger (PHP)

Generate memorable, human-readable animal-based hash digests for PHP applications.

This is a PHP port of [Helium's angry-purple-tiger](https://github.com/helium/angry-purple-tiger) library, which generates animal-based hash digests meant to be memorable and human-readable. Perfect for anthropomorphizing project names, crypto addresses, UUIDs, and other complex strings in user interfaces.

![Packagist Version](https://img.shields.io/packagist/v/seym0n/angry-purple-tiger)
![Packagist Stars](https://img.shields.io/packagist/stars/seym0n/angry-purple-tiger)
![Packagist Downloads](https://img.shields.io/packagist/dt/seym0n/angry-purple-tiger)


## Installation

Install via Composer:

```bash
composer require seym0n/angry-purple-tiger
```

## Usage

### Basic Example

```php
<?php

use Seymon\AngryPurpleTiger\Generate;

$generator = new Generate();
$digest = $generator->animalHash('my ugly input string');
echo $digest;
// Output: Rapid Grey Rattlesnake
```

### Custom Separator

```php
$digest = $generator->animalHash('my ugly input string', 'titlecase', '-');
echo $digest;
// Output: Rapid-Grey-Rattlesnake
```

### Different Styles

```php
// Lowercase
$digest = $generator->animalHash('my ugly input string', 'lowercase');
echo $digest;
// Output: rapid grey rattlesnake

// Uppercase
$digest = $generator->animalHash('my ugly input string', 'uppercase');
echo $digest;
// Output: RAPID GREY RATTLESNAKE

// Titlecase (default)
$digest = $generator->animalHash('my ugly input string', 'titlecase');
echo $digest;
// Output: Rapid Grey Rattlesnake
```

## API

### `animalHash($input, $style = 'titlecase', $separator = ' ')`

Generates an animal-based hash from the input string.

**Parameters:**
- `$input` (string, required): The string to hash
- `$style` (string, optional): Output style - `'titlecase'`, `'lowercase'`, or `'uppercase'`. Default: `'titlecase'`
- `$separator` (string, optional): Character(s) to separate words. Default: `' '` (space)

**Returns:**
- (string): A three-word animal-based hash in the format: `adjective color animal`

**Throws:**
- `\Exception`: If an unknown style is provided

## How It Works

The library:
1. Generates an MD5 hash of the input string
2. Converts the hash into bytes
3. Compresses the bytes into 3 values using XOR operations
4. Uses these values as indices to select words from three lists:
   - 256 adjectives
   - 256 colors
   - 256 animals
5. Formats and returns the three words according to the specified style and separator

## Testing

Run the test suite with PHPUnit:

```bash
composer install
vendor/bin/phpunit
```

## License

Apache 2.0

Original library © 2018 Helium Systems, Inc.
PHP port by Simon

## Credits

This is a PHP port of the original JavaScript library [angry-purple-tiger](https://github.com/helium/angry-purple-tiger) by Helium Systems, Inc.
