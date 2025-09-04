<?php

use AymanAlhattami\FilamentPageWithSidebar\Enums\PageNavigationLayoutEnum;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

test('FilamentPageSidebar sets and gets title and description correctly', function () {
    $sidebar = FilamentPageSidebar::make();

    // Test setting and getting title
    $sidebar->setTitle('Test Title');
    expect($sidebar->getTitle())->toBe('Test Title');

    // Test setting and getting description
    $sidebar->setDescription('Test Description');
    expect($sidebar->getDescription())->toBe('Test Description');

    // Test setting and getting description as copyable
    $sidebar->setDescriptionCopyable();
    expect($sidebar->getDescriptionCopyable())->toBeTrue();
});

test('FilamentPageSidebar sets and gets navigation layout correctly', function () {
    $sidebar = FilamentPageSidebar::make();

    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);

    $sidebar->topbarNavigation();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);

    $sidebar->sidebarNavigation();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);
});

test('FilamentPageSidebar filters, sorts, and groups navigation items correctly', function () {
    $navigationItems = [
        PageNavigationItem::make('Item 1')->group('Group 1'),
        PageNavigationItem::make('Item 2')->group('Group 2'),
        PageNavigationItem::make('Item 3')->group('Group 1')->visible(false), // invisible item
        PageNavigationItem::make('Item 4'), // no group
    ];

    $sidebar = FilamentPageSidebar::make()->setNavigationItems($navigationItems);

    $sortedNavigationItems = $sidebar->getNavigationItems();

    expect($sortedNavigationItems)->toHaveCount(3);
    //        ->and($sortedNavigationItems['Group 1']->items)->toHaveCount(1)
    //        ->and($sortedNavigationItems['Group 2']->items)->toHaveCount(1)
    //        ->and($sortedNavigationItems[0]->items['items'])->toHaveCount(1)// Item 3 is invisible, so it's excluded
});

test('FilamentPageSidebar handles closure values correctly', function () {
    $sidebar = FilamentPageSidebar::make();

    // Test closure for title
    $sidebar->setTitle(fn() => 'Dynamic Title');
    expect($sidebar->getTitle())->toBe('Dynamic Title');

    // Test closure for description
    $sidebar->setDescription(fn() => 'Dynamic Description');
    expect($sidebar->getDescription())->toBe('Dynamic Description');

    // Test closure for description copyable
    $sidebar->setDescriptionCopyable(fn() => true);
    expect($sidebar->getDescriptionCopyable())->toBeTrue();

    $sidebar->setDescriptionCopyable(fn() => false);
    expect($sidebar->getDescriptionCopyable())->toBeFalse();
});

test('FilamentPageSidebar handles empty navigation items', function () {
    $sidebar = FilamentPageSidebar::make()->setNavigationItems([]);
    
    expect($sidebar->getNavigationItems())->toBeEmpty();
});

test('FilamentPageSidebar handles null values correctly', function () {
    $sidebar = FilamentPageSidebar::make();
    
    expect($sidebar->getTitle())->toBeNull();
    expect($sidebar->getDescription())->toBeNull();
    expect($sidebar->getDescriptionCopyable())->toBeFalse();
});

test('FilamentPageSidebar method chaining works correctly', function () {
    $sidebar = FilamentPageSidebar::make()
        ->setTitle('Test Title')
        ->setDescription('Test Description')
        ->setDescriptionCopyable(true)
        ->topbarNavigation();

    expect($sidebar->getTitle())->toBe('Test Title');
    expect($sidebar->getDescription())->toBe('Test Description');
    expect($sidebar->getDescriptionCopyable())->toBeTrue();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);
});

test('FilamentPageSidebar can switch between navigation layouts', function () {
    $sidebar = FilamentPageSidebar::make();
    
    // Start with sidebar
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);
    
    // Switch to topbar
    $sidebar->topbarNavigation();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);
    
    // Switch back to sidebar
    $sidebar->sidebarNavigation();
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Sidebar);
    
    // Set directly
    $sidebar->setPageNavigationLayout(PageNavigationLayoutEnum::Topbar);
    expect($sidebar->getPageNavigationLayout())->toBe(PageNavigationLayoutEnum::Topbar);
});
