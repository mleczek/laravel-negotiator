# Content negotiation for Laravel API

[![Build Status](https://travis-ci.org/mleczek/laravel-negotiator.svg)](https://travis-ci.org/mleczek/laravel-negotiator)
[![Latest Stable Version](https://poser.pugx.org/mleczek/laravel-negotiator/v/stable)](https://packagist.org/packages/mleczek/laravel-negotiator)
[![License](https://poser.pugx.org/mleczek/laravel-negotiator/license)](https://packagist.org/packages/mleczek/laravel-negotiator)

- [Installation](#installation)
- [Usage](#usage)
- [Extending](#extending)
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

## Usage

Package provide `negotiate` macro for `ResponseFactory`:

```php
public function show(User $user)
{
    return response()->negotiate($user);
}
```

The same result can be achieved using `Mleczek\Negotiator\ContentNegotiation` class:

```php
public function __construct(ContentNegotiation $cn)
{
    $this->cn = $cn;
}

public function show(Request $request, User $user)
{
    return $cn->negotiate($request, $user);
}
```

For both `negotiate` method and macro there is also one parameter which override result for specified content types:

```php
public function show(User $user)
{
    // Return static JSON for request which
    // contains "application/json" in "Accepts" header.
    return response()->negotiate($user, [
        'application/json' => '{"id":4}',
    ]);
}
```

By default package support `application/json` and `application/xml`. XML format is resolved using [`mleczek/xml`](https://github.com/mleczek/xml) package.

## Extending

You can extend supported content types in `boot` method of any of your `ServiceProvider`:

```php
public function boot(ContentNegotiation $negotiator)
{
    // The ContentNegotiation facade is also available
    $negotiator->extend('application/json', function () {
        return new JsonHandler();
    });
}
```

The first parameter accept content type (or array of content types) for which the specified handler should be used.

Handler must implement the `Mleczek\Negotiator\Contracts\ContentNegotiationHandler` interface.

## Contributing

Thank you for considering contributing! If you would like to fix a bug or propose a new feature, you can submit a Pull Request.

## License

The library is licensed under the [MIT license](https://opensource.org/licenses/MIT).