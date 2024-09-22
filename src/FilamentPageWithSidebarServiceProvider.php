<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPageWithSidebarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-page-with-sidebar')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('filament-page-with-sidebar')
            ->hasAssets();

        FilamentAsset::register(
            assets: [
                Css::make('filament-page-with-sidebar', __DIR__.'/../resources/dist/app.css'),
            ],
            package: 'aymanalhattami/filament-page-with-sidebar'
        );
    }
}
