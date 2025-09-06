<?php

namespace AymanAlhattami\FilamentPageWithSidebar\Tests;

use AymanAlhattami\FilamentPageWithSidebar\FilamentPageWithSidebarServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FilamentPageWithSidebarServiceProvider::class,
        ];
    }
}
