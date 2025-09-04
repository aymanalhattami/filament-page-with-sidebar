<?php

use AymanAlhattami\FilamentPageWithSidebar\FilamentPageWithSidebarServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;

test('FilamentPageWithSidebarServiceProvider extends PackageServiceProvider', function () {
    $provider = new FilamentPageWithSidebarServiceProvider(app());
    
    expect($provider)->toBeInstanceOf(\Spatie\LaravelPackageTools\PackageServiceProvider::class);
});

test('FilamentPageWithSidebarServiceProvider configures package correctly', function () {
    $provider = new FilamentPageWithSidebarServiceProvider(app());
    
    // Use reflection to test the configurePackage method
    $reflection = new ReflectionClass($provider);
    $method = $reflection->getMethod('configurePackage');
    $method->setAccessible(true);
    
    // Create a mock package to capture configuration
    $package = new Package();
    $method->invoke($provider, $package);
    
    // Verify package configuration - check that the package was configured
    expect($package->name)->toBe('filament-page-with-sidebar');
});

test('FilamentPageWithSidebarServiceProvider can be instantiated without errors', function () {
    $provider = new FilamentPageWithSidebarServiceProvider(app());
    
    expect($provider)->toBeInstanceOf(FilamentPageWithSidebarServiceProvider::class);
    
    // Test that configurePackage method exists and is callable
    $reflection = new ReflectionClass($provider);
    expect($reflection->hasMethod('configurePackage'))->toBeTrue();
    
    $method = $reflection->getMethod('configurePackage');
    // The method should exist and be callable (it's public in the parent class)
    expect($method->isPublic())->toBeTrue();
});

test('service provider can be instantiated', function () {
    $provider = new FilamentPageWithSidebarServiceProvider(app());
    
    expect($provider)->toBeInstanceOf(FilamentPageWithSidebarServiceProvider::class);
});
