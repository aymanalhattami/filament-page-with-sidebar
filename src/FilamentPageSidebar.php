<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Filament\Support\Concerns\EvaluatesClosures;

class FilamentPageSidebar
{
    use EvaluatesClosures;

    protected string | Closure | null  $title = null;
    protected string | Closure | null  $description = null;
    protected bool | Closure $descriptionCopyable = false;
    protected array $navigationItems;
    protected bool | Closure $isWireNavigate = false;

    public function __construct()
    {
    }

    public static function make(): static
    {
        return new static();
    }

    public function setTitle(string | Closure $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    public function setDescription(string | Closure $description): static
    {
        $this->description = $this->evaluate($description);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    public function setDescriptionCopyable(bool | Closure $copyable): static
    {
        $this->descriptionCopyable = $this->evaluate($copyable);

        return $this;
    }

    public function getDescriptionCopyable(): bool
    {
        return $this->descriptionCopyable;
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

    public function wireNavigate(bool | Closure $isWireNavigate = true): static
    {
        $this->isWireNavigate = $this->evaluate($isWireNavigate);

        return $this;
    }

    public function isWireNavigate(): bool
    {
        return $this->isWireNavigate;
    }
}
