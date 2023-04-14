<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use AymanAlhattami\FilamentPageWithSidebar\Components\Page;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentPageWithSidebarServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-page-with-sidebar')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('filament-page-with-sidebar', Page::class);
    }
}
