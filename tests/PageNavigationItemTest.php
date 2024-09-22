<?php

use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

test('PageNavigationItem sets and retrieves label correctly', function () {
    // Create a PageNavigationItem instance with a label
    $item = PageNavigationItem::make('Test Label');

    // Ensure the label is returned as-is when translation is disabled
    expect($item->getLabel())->toBe('Test Label');

    // Enable translation and mock the translation function
    $item->translateLabel();
});

test('PageNavigationItem does not translate label when disabled', function () {
    // Create a PageNavigationItem instance with a label
    $item = PageNavigationItem::make(label: 'Test Label');

    // Disable translation
    $item->translateLabel(false);

    // Ensure the label is not translated
    expect($item->getLabel())->toBe('Test Label');
});
