{{-- the content of this file is copied from vendor\filament\filament\resources\views\livewire\topbar.blade.php --}}
{{-- then i customized it to fit page topbar --}}

@props([
    'sidebar',
])
<div class="fi-topbar-ctn">
    @php
        $navigation = $sidebar->getNavigationItems();
        $isRtl = __('filament-panels::layout.direction') === 'rtl';
        $isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
        $isSidebarFullyCollapsibleOnDesktop = filament()->isSidebarFullyCollapsibleOnDesktop();
        $hasTopNavigation = true;
        $hasNavigation = true;
    @endphp

    <nav class="fi-topbar">
        @if ($hasNavigation)
            <x-filament::icon-button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::OutlinedBars3"
                    :icon-alias="\Filament\View\PanelsIconAlias::TOPBAR_OPEN_SIDEBAR_BUTTON"
                    icon-size="lg"
                    :label="__('filament-panels::layout.actions.sidebar.expand.label')"
                    x-cloak
                    x-data="{}"
                    x-on:click="$store.sidebar.open()"
                    x-show="! $store.sidebar.isOpen"
                    class="fi-topbar-open-sidebar-btn"
            />

            <x-filament::icon-button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::OutlinedXMark"
                    :icon-alias="\Filament\View\PanelsIconAlias::TOPBAR_CLOSE_SIDEBAR_BUTTON"
                    icon-size="lg"
                    :label="__('filament-panels::layout.actions.sidebar.collapse.label')"
                    x-cloak
                    x-data="{}"
                    x-on:click="$store.sidebar.close()"
                    x-show="$store.sidebar.isOpen"
                    class="fi-topbar-close-sidebar-btn"
            />
        @endif

        <div class="fi-topbar-start">
            @if ($isSidebarCollapsibleOnDesktop)
                <x-filament::icon-button
                        color="gray"
                        :icon="$isRtl ? \Filament\Support\Icons\Heroicon::OutlinedChevronLeft : \Filament\Support\Icons\Heroicon::OutlinedChevronRight"
                        {{-- @deprecated Use `PanelsIconAlias::SIDEBAR_EXPAND_BUTTON_RTL` instead of `PanelsIconAlias::SIDEBAR_EXPAND_BUTTON` for RTL. --}}
                        :icon-alias="
                        $isRtl
                        ? [
                            \Filament\View\PanelsIconAlias::SIDEBAR_EXPAND_BUTTON_RTL,
                            \Filament\View\PanelsIconAlias::SIDEBAR_EXPAND_BUTTON,
                        ]
                        : \Filament\View\PanelsIconAlias::SIDEBAR_EXPAND_BUTTON
                    "
                        icon-size="lg"
                        :label="__('filament-panels::layout.actions.sidebar.expand.label')"
                        x-cloak
                        x-data="{}"
                        x-on:click="$store.sidebar.open()"
                        x-show="! $store.sidebar.isOpen"
                        class="fi-topbar-open-collapse-sidebar-btn"
                />
            @endif

            @if ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop)
                <x-filament::icon-button
                        color="gray"
                        :icon="$isRtl ? \Filament\Support\Icons\Heroicon::OutlinedChevronRight : \Filament\Support\Icons\Heroicon::OutlinedChevronLeft"
                        {{-- @deprecated Use `PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON_RTL` instead of `PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON` for RTL. --}}
                        :icon-alias="
                        $isRtl
                        ? [
                            \Filament\View\PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON_RTL,
                            \Filament\View\PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON,
                        ]
                        : \Filament\View\PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON
                    "
                        icon-size="lg"
                        :label="__('filament-panels::layout.actions.sidebar.collapse.label')"
                        x-cloak
                        x-data="{}"
                        x-on:click="$store.sidebar.close()"
                        x-show="$store.sidebar.isOpen"
                        class="fi-topbar-close-collapse-sidebar-btn"
                />
            @endif

                <div class="flex items-center rtl:space-x-reverse">
                    @if ($sidebar->getTitle() !== null || $sidebar->getDescription() !== null)
                        <div class="w-full">
                            @if ($sidebar->getTitle() != null)
                                <h3 class="text-base font-medium text-slate-700 dark:text-white truncate block">
                                    {{ $sidebar->getTitle() }}
                                </h3>
                            @endif

                            @if ($sidebar->getDescription())
                                <p class="text-xs text-gray-400 flex items-center gap-x-1">
                                    {{ $sidebar->getDescription() }}

                                    @if ($sidebar->getDescriptionCopyable())
                                        <x-filament::icon
                                                x-on:click.prevent="window.navigator.clipboard.writeText('{{ $sidebar->getDescription() }}'); $tooltip('Copied to clipboard', { timeout: 1500 })"
                                                icon="heroicon-o-clipboard-document"
                                                class="h-4 w-4 cursor-pointer hover:text-gray-700 text-gray-400 dark:text-gray-500 dark:hover:text-gray-400"/>
                                    @endif
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
        </div>

        @if ($hasTopNavigation || (! $hasNavigation))

            @if ($hasNavigation)
                <ul class="fi-topbar-nav-groups">
                    @foreach ($navigation as $group)
                        @php
                            $groupLabel = $group->getLabel();
                            $groupExtraTopbarAttributeBag = $group->getExtraTopbarAttributeBag();
                            $isGroupActive = $group->isActive();
                            $groupIcon = $group->getIcon();
                        @endphp

                        @if ($groupLabel)
                            <x-filament::dropdown
                                    placement="bottom-start"
                                    teleport
                                    :attributes="\Filament\Support\prepare_inherited_attributes($groupExtraTopbarAttributeBag)"
                            >
                                <x-slot name="trigger">
                                    <x-filament-panels::topbar.item
                                            :active="$isGroupActive"
                                            :icon="$groupIcon"
                                    >
                                        {{ $groupLabel }}
                                    </x-filament-panels::topbar.item>
                                </x-slot>

                                @php
                                    $lists = [];

                                    foreach ($group->getItems() as $item) {
                                        if ($childItems = $item->getChildItems()) {
                                            $lists[] = [
                                                $item,
                                                ...$childItems,
                                            ];
                                            $lists[] = [];

                                            continue;
                                        }

                                        if (empty($lists)) {
                                            $lists[] = [$item];

                                            continue;
                                        }

                                        $lists[count($lists) - 1][] = $item;
                                    }

                                    if (empty($lists[count($lists) - 1])) {
                                        array_pop($lists);
                                    }
                                @endphp

                                @foreach ($lists as $list)
                                    <x-filament::dropdown.list>
                                        @foreach ($list as $item)
                                            @php
                                                $isItemActive = $item->isActive();
                                                $itemBadge = $item->getBadge();
                                                $itemBadgeColor = $item->getBadgeColor();
                                                $itemBadgeTooltip = $item->getBadgeTooltip();
                                                $itemUrl = $item->getUrl();
                                                $itemIcon = $isItemActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon();
                                                $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                            @endphp

                                            <x-filament::dropdown.list.item
                                                    :badge="$itemBadge"
                                                    :badge-color="$itemBadgeColor"
                                                    :badge-tooltip="$itemBadgeTooltip"
                                                    :color="$isItemActive ? 'primary' : 'gray'"
                                                    :href="$itemUrl"
                                                    :icon="$itemIcon"
                                                    tag="a"
                                                    :target="$shouldItemOpenUrlInNewTab ? '_blank' : null"
                                            >
                                                {{ $item->getLabel() }}
                                            </x-filament::dropdown.list.item>
                                        @endforeach
                                    </x-filament::dropdown.list>
                                @endforeach
                            </x-filament::dropdown>
                        @else
                            @foreach ($group->getItems() as $item)
                                @php
                                    $isItemActive = $item->isActive();
                                    $itemActiveIcon = $item->getActiveIcon();
                                    $itemBadge = $item->getBadge();
                                    $itemBadgeColor = $item->getBadgeColor();
                                    $itemBadgeTooltip = $item->getBadgeTooltip();
                                    $itemIcon = $item->getIcon();
                                    $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                    $itemUrl = $item->getUrl();
                                @endphp

                                <x-filament-panels::topbar.item
                                        :active="$isItemActive"
                                        :active-icon="$itemActiveIcon"
                                        :badge="$itemBadge"
                                        :badge-color="$itemBadgeColor"
                                        :badge-tooltip="$itemBadgeTooltip"
                                        :icon="$itemIcon"
                                        :should-open-url-in-new-tab="$shouldItemOpenUrlInNewTab"
                                        :url="$itemUrl"
                                >
                                    {{ $item->getLabel() }}
                                </x-filament-panels::topbar.item>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif
    </nav>

    <x-filament-actions::modals />
</div>
