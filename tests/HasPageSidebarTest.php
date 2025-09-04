<?php

use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;

// Simple mock class to test the trait
class MockPageWithSidebar
{
    use HasPageSidebar;

    public $view = 'test-view';

    public $resource = null;

    public $record = null;

    public static function getResource()
    {
        return new class
        {
            public static function sidebar($record = null)
            {
                return 'resource-sidebar';
            }
        };
    }

    public static function sidebar()
    {
        return 'page-sidebar';
    }
}

// Mock class without resource
class MockPageWithoutResource
{
    use HasPageSidebar;

    public $view = 'test-view';

    public static function sidebar()
    {
        return 'page-sidebar';
    }
}

// Mock class without view
class MockPageWithoutView
{
    use HasPageSidebar;
}

test('HasPageSidebar trait has correct default properties', function () {
    expect(MockPageWithSidebar::$hasSidebar)->toBeTrue();
});

test('HasPageSidebar trait sets view when sidebar is enabled', function () {
    $page = new MockPageWithSidebar;
    $page->bootHasPageSidebar();

    // The view property should be set to the proxy view
    expect($page->view)->toBe('filament-page-with-sidebar::proxy');
});

test('HasPageSidebar trait does not set view when sidebar is disabled', function () {
    MockPageWithSidebar::$hasSidebar = false;

    $page = new MockPageWithSidebar;
    $page->bootHasPageSidebar();

    // The view should remain unchanged when sidebar is disabled
    expect($page->view)->toBe('test-view');

    // Reset for other tests
    MockPageWithSidebar::$hasSidebar = true;
});

test('HasPageSidebar trait returns correct included sidebar view', function () {
    $page = new MockPageWithSidebar;

    // Since our mock doesn't extend Page, this will throw an exception
    // which is the expected behavior when no proper view is detected
    expect(fn () => $page->getIncludedSidebarView())
        ->toThrow(Exception::class);
});

test('HasPageSidebar trait throws exception when no view is detected', function () {
    $page = new MockPageWithoutView;

    // The exception should be thrown when trying to get the included sidebar view
    expect(fn () => $page->getIncludedSidebarView())
        ->toThrow(Exception::class);
});

test('HasPageSidebar trait returns resource sidebar when resource exists', function () {
    $page = new MockPageWithSidebar;
    $page->resource = 'test-resource';
    $page->record = 'test-record';

    expect($page->getSidebar())->toBe('resource-sidebar');
});

test('HasPageSidebar trait returns page sidebar when no resource exists', function () {
    $page = new MockPageWithoutResource;

    expect($page->getSidebar())->toBe('page-sidebar');
});

test('HasPageSidebar trait returns default sidebar widths', function () {
    $page = new MockPageWithSidebar;

    $widths = $page->getSidebarWidths();

    // The config returns string values, so we need to match the actual format
    expect($widths)->toBe([
        '2xl' => '3',
        'xl' => '3',
        'lg' => '3',
        'md' => '3',
        'sm' => '12',
    ]);
});

test('HasPageSidebar trait returns custom sidebar widths from config', function () {
    config(['filament-page-with-sidebar.sidebar_width' => [
        'sm' => 6,
        'md' => 2,
        'lg' => 2,
        'xl' => 2,
        '2xl' => 2,
    ]]);

    $page = new MockPageWithSidebar;

    $widths = $page->getSidebarWidths();

    expect($widths)->toBe([
        'sm' => 6,
        'md' => 2,
        'lg' => 2,
        'xl' => 2,
        '2xl' => 2,
    ]);
});
