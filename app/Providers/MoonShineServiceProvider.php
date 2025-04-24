<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\SupplierResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\ImageResource;
use App\MoonShine\Pages\POS;
use App\MoonShine\Resources\SaleResource;
use App\MoonShine\Resources\CustomerResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\OrderItemResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                CategoryResource::class,
                SupplierResource::class,
                ProductResource::class,
                ImageResource::class,
                SaleResource::class,
                CustomerResource::class,
                OrderResource::class,
                OrderItemResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                POS::class,
            ])
        ;
    }
}
