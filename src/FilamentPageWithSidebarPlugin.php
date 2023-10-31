<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentPageWithSidebarPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

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

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}