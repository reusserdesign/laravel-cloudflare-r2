# Cloudflare R2 integration for Laravel's Storage API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/reusser/laravel-cloudflare-r2.svg?style=flat-square)](https://packagist.org/packages/reusser/laravel-cloudflare-r2)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/reusser/laravel-cloudflare-r2/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/reusserdesign/laravel-cloudflare-r2/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/reusser/laravel-cloudflare-r2/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/reusserdesign/laravel-cloudflare-r2/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/reusser/laravel-cloudflare-r2.svg?style=flat-square)](https://packagist.org/packages/reusser/laravel-cloudflare-r2)

Cloudflare R2 integration for Laravel's Storage API

## Installation

You can install the package via composer:

```bash
composer require reusser/laravel-cloudflare-r2
```

### Option 1: Use a new Disk

Add this to the disks section of config/filesystems.php:

```php
        'r2' => [
            'driver' => 'r2',
            'key' => env('R2_ACCESS_KEY_ID'),
            'secret' => env('R2_SECRET_ACCESS_KEY'),
            'region' => env('R2_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('R2_BUCKET'),
            'url' => env('R2_URL'),
            'endpoint' => env('R2_ENDPOINT', false),
            'use_path_style_endpoint' => env('R2_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
```

And fill out these in your .env:

```dotenv
R2_URL=https://some-worker.randomid.workers.dev
R2_ENDPOINT=https://randomid.r2.cloudflarestorage.com
R2_ACCESS_KEY_ID=random-key
R2_SECRET_ACCESS_KEY=random-secret
R2_BUCKET=bucket
R2_DEFAULT_REGION=us-east-1
R2_USE_PATH_STYLE_ENDPOINT=false
```

### Option 2: Use S3 Disk

Change your s3 disk to the R2 driver in config/filesystems.php:

```php
        's3' => [
            'driver' => 'r2',
            ...
```

And fill out these in your .env:

```dotenv
AWS_URL=https://some-worker.randomid.workers.dev
AWS_ENDPOINT=https://random-id.r2.cloudflarestorage.com
AWS_ACCESS_KEY_ID=random-key
AWS_SECRET_ACCESS_KEY=random-secret
AWS_BUCKET=some-bucket
AWS_DEFAULT_REGION=us-east-1
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## FAQ

### Is this package really necessary?

No, you can use the `s3` driver with Cloudflare R2, but this package makes it easier to use. Just be sure to set `'retain_visibility' => false,` in your standard `s3` configuration to prevent incompatibility issues.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Austin Drummond](https://github.com/adrum)
-   [Jake Ryan Smith](https://github.com/jakeryansmith)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
