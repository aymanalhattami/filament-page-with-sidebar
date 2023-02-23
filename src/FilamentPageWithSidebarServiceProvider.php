<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use AymanAlhattami\FilamentPageWithSidebar\Components\PageWithSidebar;

class FilamentPageWithSidebarServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-page-with-sidebar')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('filament-page-with-sidebar', PageWithSidebar::class);
    }
}
