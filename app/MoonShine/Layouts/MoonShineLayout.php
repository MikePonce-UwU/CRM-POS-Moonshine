<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Pages\POS;
use MoonShine\Laravel\Layouts\CompactLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{
    Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When
};
use App\MoonShine\Resources\CategoryResource;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\SupplierResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\ImageResource;
use App\MoonShine\Resources\SaleResource;
use App\MoonShine\Resources\CustomerResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\OrderItemResource;

final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            \MoonShine\MenuManager\MenuGroup::make('Inventario', [
                MenuItem::make('Categorías', CategoryResource::class),
                MenuItem::make('Proveedores', SupplierResource::class),
                MenuItem::make('Productos', ProductResource::class),
            ]),
            \MoonShine\MenuManager\MenuGroup::make('Punto de Ventas', [
                MenuItem::make('POS', POS::class),
                // MenuItem::make('Sales', SaleResource::class),
                MenuItem::make('Ventas', OrderResource::class),
                // MenuItem::make('OrderItems', OrderItemResource::class),
            ]),
            \MoonShine\MenuManager\MenuGroup::make('CRM', [
                MenuItem::make('Clientes', CustomerResource::class),
            ]),
            // MenuItem::make('Images', ImageResource::class),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
