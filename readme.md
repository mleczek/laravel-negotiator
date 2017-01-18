# Content negotiation for Laravel API

- [Installation](#installation)
- [Contributing](#contributing)
- [License](#license)

## Installation

Require this package with composer:

```
composer require mleczek/laravel-negotiator
```

In `config/app.php` add the `NegotiatorServiceProvider`:

```php
'providers' => [
    Mleczek\Negotiator\NegotiatorServiceProvider::class,
]
```

## Contributing

Thank you for considering contributing! If you would like to fix a bug or propose a new feature, you can submit a Pull Request.

## License

The library is licensed under the [MIT license](https://opensource.org/licenses/MIT).