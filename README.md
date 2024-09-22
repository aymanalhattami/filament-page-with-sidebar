
# Filament Page With Sidebar

[![StandWithPalestine](https://raw.githubusercontent.com/TheBSD/StandWithPalestine/main/badges/StandWithPalestine.svg)](https://github.com/TheBSD/StandWithPalestine/blob/main/docs/README.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/filament-page-with-sidebar.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-page-with-sidebar)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/filament-page-with-sidebar.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-page-with-sidebar)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/aymanalhattami/filament-page-with-sidebar/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/aymanalhattami/filament-page-with-sidebar/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aymanalhattami/filament-page-with-sidebar/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aymanalhattami/filament-page-with-sidebar/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)

Organize pages in the sidebar in order to make navigation between pages more comfortable.

> **Note:**
> It supports both pages and resource pages.

>  **Note:**
> For [Filament 2.x](https://filamentphp.com/docs/2.x/admin/installation)  use [version 1.x](https://github.com/aymanalhattami/filament-page-with-sidebar/tree/1.x)


## Screenshots
LTR (Left to Right)
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/users-view-EN.png)

RTL (Right to Left)
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/users-view-AR.png)

Please check out this video by Povilas Korop (Laravel Daily) to learn more about our package: [link](https://www.youtube.com/watch?v=J7dH8O-YBnY)


## Installation
```bash
composer require aymanalhattami/filament-page-with-sidebar
```

optionally you can publish config, views and components files
```bash
php artisan vendor:publish --tag="filament-page-with-sidebar-config"
php artisan vendor:publish --tag="filament-page-with-sidebar-views"
```
## Usage with Resource Pages
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

or add the trait ```AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar``` on any page you want the sidebar included.
This trait will add the sidebar to the Page. Add it to all your Resource Pages :

```php
// ...
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;

class ViewUser extends ViewRecord
{
    use HasPageSidebar; // use this trait to activate the Sidebar

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
```

If you want to use custom view, you can still overwrite the default value with ```protected static string $hasSidebar = false;``` and ```protected static $view = 'filament.[...].user-resource.pages.view-user';```


## Usage with Page
1. Add the trait ```AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar``` on any page you want the sidebar included.
2. Then, define the sidebar method as static in the page

```php
// ...
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Pages\Page;

class GeneralSettings extends Page
{
    use HasPageSidebar; // use this trait to activate the Sidebar

    // ...
    public static function sidebar(): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle('Application Settings')
            ->setDescription('general, admin, website, sms, payments, notifications, shipping')
            ->setNavigationItems([
                PageNavigationItem::make('General Settings')
                    ->translateLabel()
                    ->url(GeneralSettings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(GeneralSettings::getRouteName());
                    })
                    ->visible(true),
                PageNavigationItem::make('Admin Panel Settings')
                    ->translateLabel()
                    ->url(AdminPanelSettings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(AdminPanelSettings::getRouteName());
                    })
                    ->visible(true),
                PageNavigationItem::make('Web Settings')
                    ->translateLabel()
                    ->url(WebsiteSettings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(function () {
                        return request()->routeIs(WebsiteSettings::getRouteName());
                    })
                    ->visible(true),
                // ...
            ]);
    }
    
    // ...
}
```

## More Options

### Set title and description for sidebar
You can set the title or description by using setTitle, setDescription, setDescriptionCopyable methods for the sidebar that will be at the beginning of the sidebar on the top, for example 
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->setTitle('Sidebar title')
        ->setDescription('Sidebar description')
        ->setDescriptionCopyable()
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

### Set navigation layout
You can set navigation as sidebar by using ```->sidebarNavigation()``` or as topbar by using ```->topbarNavigation()```. The default layout is sidebar

#### Sidebar
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/sidebar.png)
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->sidebarNavigation();
        // 
}

// ...
```

#### Topbar
![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-page-with-sidebar/main/images/topbar.png)
```php
// ...

public static function sidebar(Model $record): FilamentPageSidebar
{
    return FilamentPageSidebar::make()
        ->topbarNavigation();
        // 
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

### Add group
You may group navigation items, for example 
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
                ->group('Manage User')

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
You can control the visibility of an item from the sidebar by using visible method, for example 
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
                ->visible(false)
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[Demo Project Link](https://github.com/aymanalhattami/filament-page-with-sidebar-project)
