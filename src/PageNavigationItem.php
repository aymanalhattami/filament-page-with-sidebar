<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Filament\Navigation\NavigationItem;

class PageNavigationItem extends NavigationItem
{
    protected bool $shouldTranslateLabel = false;

    public function translateLabel(bool $shouldTranslateLabel = true): static
    {
        $this->shouldTranslateLabel = $shouldTranslateLabel;

        return $this;
    }

    public function getLabel(): string
    {
        $label = parent::getLabel();

        return (is_string($label) && $this->shouldTranslateLabel)
            ? __($label)
            : $label;
    }
}
