# Rules for ensuring that exactly 1 of n inputs is received

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thedavefulton/laravel-exclusive-validation-rules.svg?style=flat-square)](https://packagist.org/packages/thedavefulton/laravel-exclusive-validation-rules)
[![Build Status](https://img.shields.io/travis/thedavefulton/laravel-exclusive-validation-rules/master.svg?style=flat-square)](https://travis-ci.org/thedavefulton/laravel-exclusive-validation-rules)
[![Quality Score](https://img.shields.io/scrutinizer/g/thedavefulton/laravel-exclusive-validation-rules.svg?style=flat-square)](https://scrutinizer-ci.com/g/thedavefulton/laravel-exclusive-validation-rules)
[![Total Downloads](https://img.shields.io/packagist/dt/thedavefulton/laravel-exclusive-validation-rules.svg?style=flat-square)](https://packagist.org/packages/thedavefulton/laravel-exclusive-validation-rules)

This package was born out of a need to ensure that for a set of inputs exactly 1 was received. Using existing validation rules could ensure that at least 1 or no more than 1 would be received, but there wasn't a succinct way of guaranteeing exactly one.

As such, two rules were implemented.  The first, ```require_exclusive```, ensures that exactly 1 of the inputs will be present.  The second, ```optional_exclusive```, allows for none of the inputs to be present but if any are present there must be exactly 1.

## Installation

You can install the package via composer:

```bash
composer require thedavefulton/laravel-exclusive-validation-rules
```

The package is configured to use Laravel's automatic discovery.  However, you can manually register the service provider in the ```app/config.php``` file:
``` php
'providers' => [
    // Other Service Providers

    Thedavefulton\ExclusiveValidationRulesServiceProvider::class,
],
```

## Usage
These rules may be used like any standard validation rule.
``` php
$attributes= $request->validate([
    'input1' => 'required_exclusive:input2',
    'input2' => 'required_exclusive:input1',
]);

$attributes= $request->validate([
    'input1' => 'optional_exclusive:input2',
    'input2' => 'optional_exclusive:input1',
]);
```
They can also be extended to n inputs

``` php
$attributes= $request->validate([
    'input1' => 'required_exclusive:input2,input3,input4',
    'input2' => 'required_exclusive:input1,input3,input4',
    'input3' => 'required_exclusive:input1,input2,input4',
    'input4' => 'required_exclusive:input1,input2,input3',
]);
```
### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email thedave@thedavefulton.com instead of using the issue tracker.

## Credits

- [David Fulton](https://github.com/thedavefulton)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
