@props([
    'navigation',
])

<div class="overflow-x-clip mt-8">
    <nav class="flex items-center gap-x-4 bg-white px-4 py-2 rounded-md dark:bg-gray-900 dark:ring-white/10 md:px-6 lg:px-8">
            <div class="me-6 hidden lg:flex">
                @if ($homeUrl = filament()->getHomeUrl())
                    <a {{ \Filament\Support\generate_href_html($homeUrl) }}>
                        <x-filament-panels::logo />
                    </a>
                @else
                    <x-filament-panels::logo />
                @endif
            </div>

            @if (filament()->hasNavigation())
                <ul class="me-4 hidden items-center gap-x-4 lg:flex">
                    @foreach ($navigation as $group)
                        @if ($groupLabel = $group->getLabel())
                            <x-filament::dropdown
                                    placement="bottom-start"
                                    teleport
                            >
                                <x-slot name="trigger">
                                    <x-filament-panels::topbar.item
                                            :active="$group->isActive()"
                                            :icon="$group->getIcon()"
                                    >
                                        {{ $groupLabel }}
                                    </x-filament-panels::topbar.item>
                                </x-slot>

                                <x-filament::dropdown.list>
                                    @foreach ($group->getItems() as $item)
                                        @php
                                            $icon = $item->getIcon();
                                            $shouldOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                        @endphp

                                        <x-filament::dropdown.list.item
                                                :badge="$item->getBadge()"
                                                :badge-color="$item->getBadgeColor()"
                                                :href="$item->getUrl()"
                                                :icon="$item->isActive() ? ($item->getActiveIcon() ?? $icon) : $icon"
                                                tag="a"
                                                :target="$shouldOpenUrlInNewTab ? '_blank' : null"
                                        >
                                            {{ $item->getLabel() }}
                                        </x-filament::dropdown.list.item>
                                    @endforeach
                                </x-filament::dropdown.list>
                            </x-filament::dropdown>
                        @else
                            @foreach ($group->getItems() as $item)
                                <x-filament-panels::topbar.item
                                        :active="$item->isActive()"
                                        :active-icon="$item->getActiveIcon()"
                                        :badge="$item->getBadge()"
                                        :badge-color="$item->getBadgeColor()"
                                        :icon="$item->getIcon()"
                                        :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                                        :url="$item->getUrl()"
                                >
                                    {{ $item->getLabel() }}
                                </x-filament-panels::topbar.item>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            @endif
    </nav>
</div>