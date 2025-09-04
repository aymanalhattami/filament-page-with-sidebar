<?php

use AymanAlhattami\FilamentPageWithSidebar\Enums\PageNavigationLayoutEnum;

test('PageNavigationLayoutEnum has correct values', function () {
    expect(PageNavigationLayoutEnum::Topbar->value)->toBe('topbar')
        ->and(PageNavigationLayoutEnum::Sidebar->value)->toBe('sidebar');
});

test('PageNavigationLayoutEnum can be created from string', function () {
    expect(PageNavigationLayoutEnum::from('topbar'))->toBe(PageNavigationLayoutEnum::Topbar)
        ->and(PageNavigationLayoutEnum::from('sidebar'))->toBe(PageNavigationLayoutEnum::Sidebar);
});

test('PageNavigationLayoutEnum can be created from string with tryFrom', function () {
    expect(PageNavigationLayoutEnum::tryFrom('topbar'))->toBe(PageNavigationLayoutEnum::Topbar)
        ->and(PageNavigationLayoutEnum::tryFrom('sidebar'))->toBe(PageNavigationLayoutEnum::Sidebar)
        ->and(PageNavigationLayoutEnum::tryFrom('invalid'))->toBeNull();
});

test('PageNavigationLayoutEnum has all expected cases', function () {
    $cases = PageNavigationLayoutEnum::cases();
    
    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(PageNavigationLayoutEnum::Topbar)
        ->and($cases)->toContain(PageNavigationLayoutEnum::Sidebar);
});
