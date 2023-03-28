<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Filament\Navigation\NavigationItem;

class PageNavigationItem extends NavigationItem
{
    protected bool $isHidden = false;
    protected bool $shouldTranslateLabel = false;

    public function isHiddenWhen(Closure|bool $condition): static
    {
        $this->isHidden = $condition instanceof Closure ? $condition() : $condition;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    public function translateLabel(bool $shouldTranslateLabel = true): static
    {
        $this->shouldTranslateLabel = $shouldTranslateLabel;

        return $this;
    }

    public function getLabel(): string
    {
        return (is_string($this->label) && $this->shouldTranslateLabel) ?
            __($this->label) :
            $this->label;
    }
}