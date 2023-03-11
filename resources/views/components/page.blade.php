@props([
    'filamentResource' => null,
    'recordId' => null,
])

@php
    $sidebar = $filamentResource::sidebar($recordId);
@endphp

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 md:col-span-{{ config('filament-page-with-sidebar.sidebar_width.md') }} lg:col-span-{{ config('filament-page-with-sidebar.sidebar_width.lg') }} xl:col-span-{{ config('filament-page-with-sidebar.sidebar_width.xl') }} 2xl:col-span-{{ config('filament-page-with-sidebar.sidebar_width.2xl') }} rounded">
        <div class="">
            <div class="flex items-center rtl:space-x-reverse">
                <div class="w-full">
                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 truncate block">
                        {{ $sidebar->getTitle() }}
                    </h3>
                    <p class="text-xs text-gray-500">
                        {{ $sidebar->getDescription() }}</p>
                </div>
            </div>
            <ul class="mt-4 space-y-2 font-inter font-medium" wire:ignore>
                @foreach ($sidebar->getNavigationItems() as $item)
                    <x-filament::layouts.app.sidebar.item
                        :active="$item->isActive()"
                        :icon="$item->getIcon()"
                        :active-icon="$item->getActiveIcon()"
                        :url="$item->getUrl()"
                        :badge="$item->getBadge()"
                        :badgeColor="$item->getBadgeColor()"
                        :shouldOpenUrlInNewTab="$item->shouldOpenUrlInNewTab()">
                        {{ $item->getLabel() }}
                    </x-filament::layouts.app.sidebar.item>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-span-12 md:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.md') }} lg:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.lg') }} xl:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.xl') }} 2xl:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.2xl') }}">
        {{ $slot }}
    </div>
</div>
