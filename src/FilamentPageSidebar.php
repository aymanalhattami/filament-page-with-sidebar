<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Filament\Support\Concerns\EvaluatesClosures;

class FilamentPageSidebar
{
    use EvaluatesClosures;

    protected ?string $title = null;
    protected ?string $description = null;
    protected array $navigationItems;

    public function __construct()
    {
    }

    public static function make(): static
    {
        return new static();
    }


    public function setTitle(Closure | string $title): static
    {
        $this->title = $this->evaluate($title);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(Closure | string $description): static
    {
        $this->description = $this->evaluate($description);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setNavigationItems(array $navigationItems): static
    {
        $this->navigationItems = $navigationItems;

        return $this;
    }

    public function getNavigationItems(): array
    {
        return $this->navigationItems;
    }
}
