<?php

use AymanAlhattami\FilamentPageWithSidebar\Enums\PageNavigationLayoutEnum;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

test('complete sidebar workflow works correctly', function () {
    // Create navigation items
    $navigationItems = [
        PageNavigationItem::make('Dashboard')->group('Main'),
        PageNavigationItem::make('Users')->group('Management'),
        PageNavigationItem::make('Settings')->group('Main'),
        PageNavigationItem::make('Profile'), // No group
    ];

    // Create sidebar with all features
    $sidebar = FilamentPageSidebar::make()
        ->setTitle('Admin Panel')
        ->setDescription('Manage your application')
        ->setDescriptionCopyable()
        ->setNavigationItems($navigationItems)
        ->sidebarNavigation();

    // Verify all properties
    expect($sidebar->getTitle())->toBe('Admin Panel')
        ->and($sidebar->getDescription())->toBe('Manage your application')
        ->and($sidebar->getDescriptionCopyable())->toBeTrue()
        ->and($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);

    // Verify navigation items are processed correctly
    $processedItems = $sidebar->getNavigationItems();
    expect($processedItems)->toHaveCount(3); // 3 groups (Main, Management, and ungrouped)
});

test('sidebar can switch to topbar navigation', function () {
    $sidebar = FilamentPageSidebar::make()
        ->setTitle('Test Title')
        ->sidebarNavigation();

    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);

    $sidebar->topbarNavigation();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);
});

test('navigation items with different visibility work correctly', function () {
    $navigationItems = [
        PageNavigationItem::make('Visible Item 1')->group('Group 1'),
        PageNavigationItem::make('Visible Item 2')->group('Group 1'),
        PageNavigationItem::make('Hidden Item')->group('Group 1')->visible(false),
        PageNavigationItem::make('Visible Item 3'), // No group
    ];

    $sidebar = FilamentPageSidebar::make()->setNavigationItems($navigationItems);
    $processedItems = $sidebar->getNavigationItems();

    // Should have 2 groups: Group 1 and ungrouped
    expect($processedItems)->toHaveCount(2);
});

test('sidebar with closure values works in real scenario', function () {
    $user = (object) ['name' => 'John Doe'];
    
    $sidebar = FilamentPageSidebar::make()
        ->setTitle(fn() => "Welcome, {$user->name}")
        ->setDescription(fn() => "Last login: " . date('Y-m-d'))
        ->setDescriptionCopyable(fn() => true);

    expect($sidebar->getTitle())->toBe('Welcome, John Doe')
        ->and($sidebar->getDescription())->toContain('Last login:')
        ->and($sidebar->getDescriptionCopyable())->toBeTrue();
});

test('multiple sidebar instances work independently', function () {
    $sidebar1 = FilamentPageSidebar::make()
        ->setTitle('Sidebar 1')
        ->setDescription('Description 1')
        ->sidebarNavigation();

    $sidebar2 = FilamentPageSidebar::make()
        ->setTitle('Sidebar 2')
        ->setDescription('Description 2')
        ->topbarNavigation();

    expect($sidebar1->getTitle())->toBe('Sidebar 1')
        ->and($sidebar1->getDescription())->toBe('Description 1')
        ->and($sidebar1->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar)
        ->and($sidebar2->getTitle())->toBe('Sidebar 2')
        ->and($sidebar2->getDescription())->toBe('Description 2')
        ->and($sidebar2->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);

});
