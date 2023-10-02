<?php

namespace AymanAlhattami\FilamentPageWithSidebar;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Concerns\EvaluatesClosures;

class FilamentPageSidebar
{
    use EvaluatesClosures;

    protected string | Closure | null  $title = null;
    protected string | Closure | null  $description = null;
    protected bool | Closure $descriptionCopyable = false;
    protected array $navigationItems;

    public function __construct()
    {
    }

    public static function make(): static
    {
        return new static();
    }

    public function setTitle(string | Closure $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    public function setDescription(string | Closure $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    public function setDescriptionCopyable(bool | Closure $copyable = true): static
    {
        $this->descriptionCopyable = $copyable;

        return $this;
    }

    public function getDescriptionCopyable(): bool
    {
        return $this->evaluate($this->descriptionCopyable);
    }

    public function setNavigationItems(array $navigationItems): static
    {
        $this->navigationItems = $navigationItems;

        return $this;
    }

    public function getNavigationItems(): array
    {
        return collect($this->navigationItems)
            ->filter(fn (PageNavigationItem $item): bool => $item->isVisible())
            ->sortBy(fn (PageNavigationItem $item): int => $item->getSort())
            ->groupBy(fn (PageNavigationItem $item): ?string => $item->getGroup())
            ->map(function (Collection $items, ?string $groupIndex): NavigationGroup {
                if (blank($groupIndex)) {
                    return NavigationGroup::make()->items($items);
                }

                $registeredGroup = collect([])
                    ->first(function (NavigationGroup | string $registeredGroup, string | int $registeredGroupIndex) use ($groupIndex) {
                        if ($registeredGroupIndex === $groupIndex) {
                            return true;
                        }

                        if ($registeredGroup === $groupIndex) {
                            return true;
                        }

                        if (! $registeredGroup instanceof NavigationGroup) {
                            return false;
                        }

                        return $registeredGroup->getLabel() === $groupIndex;
                    });

                if ($registeredGroup instanceof NavigationGroup) {
                    return $registeredGroup->items($items);
                }

                return NavigationGroup::make($registeredGroup ?? $groupIndex)
                    ->items($items);
            })
            ->sortBy(function (NavigationGroup $group, ?string $groupIndex): int {
                if (blank($group->getLabel())) {
                    return -1;
                }

                $registeredGroups = [];

                $groupsToSearch = $registeredGroups;

                if (Arr::first($registeredGroups) instanceof NavigationGroup) {
                    $groupsToSearch = [
                        ...array_keys($registeredGroups),
                        ...array_map(fn (NavigationGroup $registeredGroup): string => $registeredGroup->getLabel(), array_values($registeredGroups)),
                    ];
                }

                $sort = array_search(
                    $groupIndex,
                    $groupsToSearch,
                );

                if ($sort === false) {
                    return count($registeredGroups);
                }

                return $sort;
            })
            ->all();
    }
}
