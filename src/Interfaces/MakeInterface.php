<?php

namespace AymanAlhattami\FilamentPageWithSidebar\Interfaces;

interface MakeInterface
{
    public function __construct();

    public static function make(): static;
}
