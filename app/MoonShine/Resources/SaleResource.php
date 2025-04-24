<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\Attributes\Order as AttributesOrder;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;

#[Icon('square-3-stack-3d')]
// #[Group('Inventario')]
#[AttributesOrder(2)]
/**
 * @extends ModelResource<Sale>
 */
class SaleResource extends ModelResource
{
    protected string $model = Order::class;

    protected string $title = 'Ventas';

    // protected string $column = 'name';
    protected array $with = [];
    protected bool $simplePaginate = true;

    protected bool $columnSelection = true;

    // protected bool $isAsync = false;
    // protected bool $errorsAbove = false;

    // protected bool $createInModal = true;
    // protected bool $editInModal = true;
    // protected bool $deleteInModal = true;
    // protected bool $detailInModal = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            // ID::make()->sortable(),
            \MoonShine\UI\Fields\Number::make('# Orden', 'order_number')->sortable(),
            \MoonShine\UI\Fields\Text::make('Cliente', 'customer.name')->sortable(),
            \MoonShine\Laravel\Fields\Relationships\BelongsToMany::make('Productos', 'products', resource: ProductResource::class)
                ->relatedLink(),
            \MoonShine\UI\Fields\Number::make('Total', 'total'),
        ];
    }
    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->only(\MoonShine\Laravel\Enums\Action::VIEW);
    }

    //-------------------------------------------------------------------------

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            \MoonShine\UI\Fields\Number::make('# Orden', 'order_number')->sortable(),
            \MoonShine\UI\Fields\Text::make('Cliente', 'customer.name')->sortable(),
            \MoonShine\Laravel\Fields\Relationships\BelongsToMany::make('Productos', 'products', resource: ProductResource::class)
                ->fields([
                    \MoonShine\UI\Fields\Number::make('Cantidad', 'quantity'),
                    \MoonShine\UI\Fields\Text::make('Precio', 'product.price'),
                ]),
            \MoonShine\UI\Fields\Number::make('Total', 'total'),
        ];
    }

    /**
     * @param Sale $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
