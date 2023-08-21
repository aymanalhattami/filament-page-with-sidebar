<?php

namespace AymanAlhattami\FilamentPageWithSidebar\Traits;

trait HasPageSidebar
{
    /**
     * public function mountHasPageSidebar
     *   Register automatically view if available
     */
    public function mountHasPageSidebar(): void
    {
        // Using ${'view'} instead of $view in order to avoid Intelephense warning
        if (isset(static::${'view'})) {
            static::${'view'} = 'filament-page-with-sidebar::proxy';
        }
    }

    /**
     * public function getIncludedSidebarView
     *   Return string include view
     */
    public function getIncludedSidebarView(): string
    {
        return collect(class_parents($this))
            ->filter(function ($class) {
                return is_subclass_of($class, '\Filament\Pages\Page');
            })
            ->map(function ($class) {
                return (new \ReflectionClass($class))->getDefaultProperties()['view'] ?? null;
            })
            ->filter()
            ->first()
            ?: throw new \Exception('No view detected for the Sidebar. Implement Filament\Pages\Page object with valid static $view');
    }
}
