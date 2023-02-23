<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

class FilamentPageSidebar
{
    protected string $view;
    protected string $title;
    protected string $description;
    protected array $navigationItems;

    public function __construct(?string $view = null)
    {
        if (filled($view)) {
            $this->setView($view);
        }
    }

    public static function make(?string $view = null): static
    {
        return new static($view);
    }

    public function setView(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getView(): string
    {
        return $this->view;
    }
    

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
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