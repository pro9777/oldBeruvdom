<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Перейти на сайт')
                ->target()
                ->icon('eye')
                ->route('home'),

            Menu::make('Главная')
                ->icon('home')
                ->route('platform.home'),

            Menu::make('Старницы')
                ->icon('docs')
                ->route('platform.page'),

            Menu::make('Заказы')
                ->icon('basket-loaded')
                ->permission('platform.cart')
                ->route('platform.cart'),

            Menu::make('Статьи')
                ->icon('book-open')
                ->route('platform.stati'),

            Menu::make('Категории')
                ->icon('folder')
                ->route('platform.category')
                ->permission('platform.category'),

            Menu::make('Все товары')
                ->icon('folder')
                ->route('platform.allproducts')
                ->permission('platform.category'),

            Menu::make(__('AmoCrm'))
                ->icon('key')
                ->route('platform.amocrm')
                ->permission('platform.amocrm')
                ->title(__('Access rights')),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users'),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

//            Menu::make(__('Roles'))
//                ->icon('lock')
//                ->route('platform.systems.roles')
//                ->permission('platform.systems.roles'),


//            Menu::make('Example screen')
//                ->icon('monitor')
//                ->route('platform.example')
//                ->title('Navigation')
//                ->badge(fn () => 6),
//

//
//            Menu::make('Basic Elements')
//                ->title('Form controls')
//                ->icon('note')
//                ->route('platform.example.fields'),
//
//            Menu::make('Advanced Elements')
//                ->icon('briefcase')
//                ->route('platform.example.advanced'),
//
//            Menu::make('Text Editors')
//                ->icon('list')
//                ->route('platform.example.editors'),
//
//            Menu::make('Overview layouts')
//                ->title('Layouts')
//                ->icon('layers')
//                ->route('platform.example.layouts'),
//
//            Menu::make('Chart tools')
//                ->icon('bar-chart')
//                ->route('platform.example.charts'),
//
//            Menu::make('Cards')
//                ->icon('grid')
//                ->route('platform.example.cards')
//                ->divider(),
//
//            Menu::make('Documentation')
//                ->title('Docs')
//                ->icon('docs')
//                ->url('https://orchid.software/en/docs'),
//
//            Menu::make('Changelog')
//                ->icon('shuffle')
//                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
//                ->target('_blank')
//                ->badge(fn () => Dashboard::version(), Color::DARK()),
//
//            Menu::make(__('Users'))
//                ->icon('user')
//                ->route('platform.systems.users')
//                ->permission('platform.systems.users')
//                ->title(__('Access rights')),
//

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.amocrm', __('AmoCrm'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Категории'))
                ->addPermission('platform.category', __('Категории'))
                ->addPermission('platform.category.show', __('Подкатегории')),
            ItemPermission::group(__('Товары'))
                ->addPermission('platform.product', __('Редактирование товара'))
                ->addPermission('platform.category.calculator', __('Редактирование товара калькулятора')),
            ItemPermission::group(__('Заказы'))
                ->addPermission('platform.cart', __('Заказы'))
                ->addPermission('platform.category.cal culator', __('Редактирование товара калькулятора')),
        ];
    }
}
