<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

class FilamentPageSidebar
{
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
    

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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