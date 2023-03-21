<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Filament\Navigation\NavigationItem;

class PageNavigationItem extends NavigationItem
{
    protected bool $isHidden = false;

    public function isHiddenWhen(Closure|bool $condition): static
    {
        $this->isHidden = $condition instanceof Closure ? $condition() : $condition;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->isHidden;
    }
}