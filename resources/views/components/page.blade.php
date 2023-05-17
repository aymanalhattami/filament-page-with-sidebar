@php
    $sidebar = static::getResource()::sidebar($this->record);
@endphp

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div
        class="col-span-12 md:col-span-{{ config('filament-page-with-sidebar.sidebar_width.md') }} lg:col-span-{{ config('filament-page-with-sidebar.sidebar_width.lg') }} xl:col-span-{{ config('filament-page-with-sidebar.sidebar_width.xl') }} 2xl:col-span-{{ config('filament-page-with-sidebar.sidebar_width.2xl') }} rounded">
        <div class="">
            <div class="flex items-center rtl:space-x-reverse">
                @if ($sidebar->getTitle() != null || $sidebar->getDescription() != null)
                    <div class="w-full">
                        @if ($sidebar->getTitle() != null)
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 truncate block">
                                {{ $sidebar->getTitle() }}
                            </h3>
                        @endif

                        @if ($sidebar->getDescription())
                            <p class="text-xs text-gray-500">
                                {{ $sidebar->getDescription() }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <ul class="@if ($sidebar->getTitle() != null || $sidebar->getDescription() != null) mt-4 @endif space-y-2 font-inter font-medium" wire:ignore>
                @foreach ($sidebar->getNavigationItems() as $item)
                    @if (!$item->isHidden())
                        <x-filament-page-with-sidebar::item>
                            :active="$item->isActive()"
                            :icon="$item->getIcon()"
                            :active-icon="$item->getActiveIcon()"
                            :url="$item->getUrl()"
                            :badge="$item->getBadge()"
                            :badgeColor="$item->getBadgeColor()"
                            :shouldOpenUrlInNewTab="$item->shouldOpenUrlInNewTab()">
                            {{ $item->getLabel() }}
                        </x-filament-page-with-sidebar::item>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div
        class="col-span-12 md:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.md') }} lg:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.lg') }} xl:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.xl') }} 2xl:col-span-{{ 12 - config('filament-page-with-sidebar.sidebar_width.2xl') }}">
        {{ $slot }}
    </div>
</div>
