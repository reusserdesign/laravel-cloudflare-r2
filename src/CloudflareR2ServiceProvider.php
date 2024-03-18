<?php

namespace Reusser\CloudflareR2;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Reusser\CloudflareR2\Filesystems\CloudflareR2FileSystem;

class CloudflareR2ServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        Storage::extend('r2', function (Application $app, array $config) {
            return CloudflareR2FileSystem::create($config);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-cloudflare-r2')
            ->publishesServiceProvider('CloudflareR2ServiceProvider');
    }
}
