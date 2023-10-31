<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentPageWithSidebarPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-page-with-sidebar';
    }

    public function register(Panel $panel): void
    {
        // TODO: Implement register() method.
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}