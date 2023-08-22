<?php

namespace AymanAlhattami\FilamentPageWithSidebar\Traits;

trait HasPageSidebar
{
    /**
     * public function mountHasPageSidebar
     *   Register automatically view if available
     */
    public function bootHasPageSidebar(): void
    {
        // Why boot ? https://livewire.laravel.com/docs/lifecycle-hooks#boot

        // Using ${'view'} instead of $view in order to avoid Intelephense warning
        if (isset(static::${'viewSidebar'})) {
            static::${'view'} = static::${'viewSidebar'};
        } elseif (isset(static::${'view'})) {
            static::${'view'} = 'filament-page-with-sidebar::proxy';
        }
    }

    /**
     * public function getIncludedSidebarView
     *   Return string include view
     */
    public function getIncludedSidebarView(): string
    {
        if (is_subclass_of($this, '\Filament\Pages\Page')) {
            $props = collect(
                (new \ReflectionClass($this))->getDefaultProperties()
            );

            if ($props->get('view')) {
                return $props->get('view');
            }
        }

        // Else:
        throw new \Exception('No view detected for the Sidebar. Implement Filament\Pages\Page object with valid static $view');
    }
}
