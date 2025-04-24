<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Order>
 */
class OrderResource extends ModelResource
{
    protected string $model = Order::class;

    protected string $title = 'Orders';

    protected array $with = ['customer'];
    protected bool $simplePaginate = true;

    protected bool $columnSelection = true;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            // ID::make()->sortable(),
            \MoonShine\UI\Fields\Number::make('# Orden', 'order_number')->sortable(),
            \MoonShine\UI\Fields\Text::make('Cliente', 'customer.name')->sortable(),
            // \MoonShine\UI\Fields\Number::make('Productos', 'order_items.count')->sortable(),
            // \MoonShine\Laravel\Fields\Relationships\BelongsToMany::make('Productos', 'order_items')
            //     ->relatedLink(),
            \MoonShine\UI\Fields\Number::make('Total', 'total_amount'),
        ];
    }

    // protected function activeActions(): ListOf
    // {
    //     return parent::activeActions()
    //         ->only(\MoonShine\Laravel\Enums\Action::VIEW);
    // }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                \MoonShine\UI\Fields\Number::make('# Orden', 'order_number'),
                \MoonShine\Laravel\Fields\Relationships\BelongsTo::make('Cliente', 'customer', resource: CustomerResource::class),
                \MoonShine\UI\Fields\Date::make('Fecha', 'order_date'),
                \MoonShine\Laravel\Fields\Relationships\RelationRepeater::make('Productos', 'order_items', resource: OrderItemResource::class)
                    ->fields([
                        \MoonShine\Laravel\Fields\Relationships\BelongsTo::make('Producto', 'product', resource: ProductResource::class),
                        \MoonShine\UI\Fields\Number::make('Cantidad', 'quantity'),
                    ]),
                \MoonShine\UI\Fields\Select::make('Estado', 'status')
                    ->options([
                        'pending' => 'Pendiente',
                        'completed' => 'Completada',
                        'canceled' => 'Cancelada',
                    ]),
                \MoonShine\UI\Fields\Number::make('Total', 'total_amount'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            // ID::make(),
            \MoonShine\UI\Fields\Number::make('# Orden', 'order_number'),
            \MoonShine\UI\Fields\Text::make('Cliente', 'customer.name'),
            \MoonShine\UI\Fields\Date::make('Fecha', 'order_date'),
            \MoonShine\Laravel\Fields\Relationships\BelongsToMany::make('Productos', 'order_items', resource: OrderItemResource::class)
                ->fields([
                    \MoonShine\UI\Fields\Number::make('Cantidad', 'quantity'),
                    \MoonShine\UI\Fields\Text::make('Precio', 'product.price'),
                ]),
            \MoonShine\UI\Fields\Number::make('Total', 'total_amount'),
        ];
    }

    /**
     * @param Order $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
