
# Filament Page With Sidebar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/filament-page-with-sidebar.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-page-with-sidebar)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/filament-page-with-sidebar.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-page-with-sidebar)

Organize resource pages in the sidebar in order to make navigation between resource pages more comfortable.


## Screenshots
LTR (Left to Right)
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/users-view-EN.png)

RTL (Right to Left)
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/users-view-AR.png)

Please check out this video by Povilas Korop (Laravel Daily) to learn more about our package: [link](https://www.youtube.com/watch?v=J7dH8O-YBnY)

> **Note:**
> For Filament 2.x use version 1.x

## Installation
```bash
composer require aymanalhattami/filament-page-with-sidebar
```

optionally you can publish config, views and components files
```bash
php artisan vendor:publish --tag="filament-page-with-sidebar-config"
php artisan vendor:publish --tag="filament-page-with-sidebar-views"
```
## Usage
1. First you need to prepare resource pages, for example, we have an edit page, view page, manage page, change password page, and dashboar page for UserResource
```php
use Filament\Resources\Resource;

class UserResource extends Resource 
{
    // ...

    public static function getPages(): array
    {
        return [
            'index' => App\Filament\Resources\UserResource\Pages\ListUsers::route('/'),
            'edit' => App\Filament\Resources\UserResource\Pages\EditUser::route('/{record}/edit'),
            'view' => App\Filament\Resources\UserResource\Pages\ViewUser::route('/{record}/view'),
            'manage' => App\Filament\Resources\UserResource\Pages\ManageUser::route('/{record}/manage'),
            'password.change' => App\Filament\Resources\UserResource\Pages\ChangePasswordUser::route('/{record}/password/change'),
            'dashboard' => App\Filament\Resources\UserResource\Pages\DashboardUser::route('/{record}/dashboard'),
            // ... more pages
        ];
    }

    // ...
}
```

2. Define a $record property in each custom page, example

```php
public ModelName $record; // public User $record;
```

3. Then, define the sidebar method as static in the resource
```php
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Resource;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

class UserResource extends Resource 
{
    // ....

    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setNavigationItems([
                PageNavigationItem::make('User Dashboard')
                    ->url(function () use ($record) {
                        return static::getUrl('dashboard', ['record' => $record->id]);
                    }),
                PageNavigationItem::make('View User')
                    ->url(function () use ($record) {
                        return static::getUrl('view', ['record' => $record->id]);
                    }),
                PageNavigationItem::make('Edit User')
                    ->url(function () use ($record) {
                        return static::getUrl('edit', ['record' => $record->id]);
                    }),
                PageNavigationItem::make('Manage User')
                    ->url(function () use ($record) {
                        return static::getUrl('manage', ['record' => $record->id]);
                    }),
                PageNavigationItem::make('Change Password')
                    ->url(function () use ($record) {
                        return static::getUrl('password.change', ['record' => $record->id]);
                    }),

                // ... more items
            ]);
    }

    // ....
}
```

4. Use x-filament-page-with-sidebar::page component in the page blade file as a wrapper for the whole content
```php
// filament.resources.user-resource.pages.change-password-user
<x-filament-page-with-sidebar::page>
    // ... page content
</x-filament-page-with-sidebar::page>

```

## More Options

### Set title and description for sidebar
You can set the title or description by using setTitle and setDescription methods for the sidebar that will be at the beginning of the sidebar on the top, for example 
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setTitle('Sidebar title')
        ->setDescription('Sidebar description')
        ->setNavigationItems([
            PageNavigationItem::make(__('User Dashboard'))
                ->url(function () use ($record) {
                    return static::getUrl('dashboard', ['record' => $record->id]);
                }),
            PageNavigationItem::make(__('View User'))
                ->url(function () use ($record) {
                    return static::getUrl('view', ['record' => $record->id]);
                }),

            // ... more items
        ]);
}

// ...
```

### Add icon
You can add an icon to the item by using the icon method, for example 
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setNavigationItems([
            PageNavigationItem::make('Change Password')
                ->url(function () use ($record) {
                    return static::getUrl('password.change', ['record' => $record->id]);
                })->icon('heroicon-o-collection')

            // ... more items
        ]);
}

// ...
```

### Set active item
You can make an item active "has a different background color" by using isActiveWhen method, for example 
```php
// ...
public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setNavigationItems([
            PageNavigationItem::make('Change Password')
                ->url(function () use ($record) {
                    return static::getUrl('password.change', ['record' => $record->id]);
                })
                ->isActiveWhen(function () {
                    return request()->route()->action['as'] == 'filament.resources.users.password.change';
                })
            // ... more items
        ]);
}
// ...
```

### Hide the item
You can hide an item from the sidebar by using isHiddenWhen method, for example 
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setNavigationItems([
            PageNavigationItem::make('Change Password')
                ->url(function () use ($record) {
                    return static::getUrl('password.change', ['record' => $record->id]);
                })
                ->isHiddenWhen(false)
            // ... more items
        ]);
}
    ,
// ...
```

### Add bage to the item
You can add a badge to the item by using the badge method, for example 
```php
// ...
public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setNavigationItems([
            PageNavigationItem::make('Change Password')
                ->url(function () use ($record) {
                    return static::getUrl('password.change', ['record' => $record->id]);
                })
                ->badge("badge name")
            // ... more items
        ]);
}
    ,
// ...
```

### Translate the item
You can translate a label by using translateLabel method, for example 
```php
// ...
public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()->translateLabel()
        ->setNavigationItems([
            PageNavigationItem::make('Change Password')
                ->url(function () use ($record) {
                    return static::getUrl('password.change', ['record' => $record->id]);
                })
            // ... more items
        ]);
}
    ,
// ...
```

[Demo Project Link](https://github.com/aymanalhattami/filament-page-with-sidebar-project)
