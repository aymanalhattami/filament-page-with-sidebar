<?php

namespace AymanAlhattami\FilamentPageWithSidebar\Components;

use Illuminate\View\Component;

class Page extends Component
{
    public string $filamentResource;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $filamentResource)
    {
        $this->filamentResource = $filamentResource;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('filament-page-with-sidebar::components.page');
    }
}
