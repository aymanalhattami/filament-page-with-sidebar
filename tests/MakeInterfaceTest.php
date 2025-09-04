<?php

use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\Interfaces\MakeInterface;

test('FilamentPageSidebar implements MakeInterface', function () {
    expect(FilamentPageSidebar::class)->toImplement(MakeInterface::class);
});

test('MakeInterface requires make method', function () {
    $reflection = new ReflectionClass(MakeInterface::class);
    $methods = $reflection->getMethods();
    
    $methodNames = array_map(fn($method) => $method->getName(), $methods);
    
    expect($methodNames)->toContain('make')
        ->and($methodNames)->toContain('__construct');
});

test('FilamentPageSidebar make method returns instance', function () {
    $instance = FilamentPageSidebar::make();
    
    expect($instance)->toBeInstanceOf(FilamentPageSidebar::class)
        ->and($instance)->toBeInstanceOf(MakeInterface::class);
});

test('FilamentPageSidebar can be instantiated directly', function () {
    $instance = new FilamentPageSidebar();
    
    expect($instance)->toBeInstanceOf(FilamentPageSidebar::class)
        ->and($instance)->toBeInstanceOf(MakeInterface::class);
});
