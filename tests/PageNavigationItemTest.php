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

test('PageNavigationItem method chaining works correctly', function () {
    $item = PageNavigationItem::make('Test Label')
        ->translateLabel();

    expect($item->getLabel())->toBe('Test Label');
});

test('PageNavigationItem extends NavigationItem correctly', function () {
    $item = PageNavigationItem::make('Test Label');
    
    expect($item)->toBeInstanceOf(\Filament\Navigation\NavigationItem::class);
});

test('PageNavigationItem can be created with different parameters', function () {
    $item1 = PageNavigationItem::make('Label 1');
    $item2 = PageNavigationItem::make(label: 'Label 2');
    
    expect($item1->getLabel())->toBe('Label 1')
        ->and($item2->getLabel())->toBe('Label 2');
});

test('PageNavigationItem translation state can be toggled', function () {
    $item = PageNavigationItem::make('Test Label');
    
    // Initially disabled
    $item->translateLabel(false);
    expect($item->getLabel())->toBe('Test Label');
    
    // Enable translation
    $item->translateLabel(true);
    expect($item->getLabel())->toBe('Test Label'); // Still same since no translation key
    
    // Disable again
    $item->translateLabel(false);
    expect($item->getLabel())->toBe('Test Label');
});
