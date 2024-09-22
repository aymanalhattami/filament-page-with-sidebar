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
    $sidebar->setDescriptionCopyable(true);
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

    //    dd($sortedNavigationItems);

    expect($sortedNavigationItems)->toHaveCount(3);
    //        ->and($sortedNavigationItems['Group 1']->items)->toHaveCount(1)
    //        ->and($sortedNavigationItems['Group 2']->items)->toHaveCount(1)
    //        ->and($sortedNavigationItems[0]->items['items'])->toHaveCount(1)// Item 3 is invisible, so it's excluded
});
