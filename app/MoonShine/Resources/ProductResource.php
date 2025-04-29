<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

#[Icon('squares-plus')]
// #[Group('Inventario')]
#[Order(2)]
/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Products';

    protected string $column = 'name';
    protected array $with = [];
    protected bool $simplePaginate = true;

    protected bool $columnSelection = true;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;

    protected bool $createInModal = true;
    protected bool $editInModal = true;
    protected bool $deleteInModal = true;
    protected bool $detailInModal = true;

    protected ?\MoonShine\Support\Enums\PageType $redirectAfterSave = \MoonShine\Support\Enums\PageType::INDEX;


    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            \MoonShine\UI\Fields\Image::make('Imagen', 'image.url')
                ->disk('products'),
            \MoonShine\UI\Fields\Text::make('Nombre', 'name')->sortable(),
            \MoonShine\UI\Fields\Text::make('Descripción', 'description')->sortable(),
            \MoonShine\UI\Fields\Text::make('Precio', 'price')->sortable(),
            \MoonShine\UI\Fields\Text::make('Stock', 'stock')->sortable()->badge(fn($value) => $value > 10 ? 'green' : 'red'),
            \MoonShine\UI\Fields\Text::make('Categoría', 'category.name'),
            \MoonShine\UI\Fields\Text::make('Proveedor', 'supplier.name'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                \MoonShine\UI\Fields\Text::make('Nombre', 'name'),
                \MoonShine\UI\Fields\Text::make('Descripción', 'description'),
                \MoonShine\UI\Fields\Text::make('Precio', 'price'),
                \MoonShine\UI\Fields\Text::make('Stock', 'stock'),
                \MoonShine\Laravel\Fields\Relationships\BelongsTo::make('Categoría', 'category', resource: CategoryResource::class),
                \MoonShine\Laravel\Fields\Relationships\BelongsTo::make('Proveedor', 'supplier', resource: SupplierResource::class),
                \MoonShine\Laravel\Fields\Relationships\RelationRepeater::make('Imágenes', 'images', resource: ImageResource::class)
                    ->removable(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            \MoonShine\UI\Fields\Image::make('Imagen', 'image.url')
                ->disk('products'),
            \MoonShine\UI\Fields\Text::make('Nombre', 'name'),
            \MoonShine\UI\Fields\Text::make('Descripción', 'description'),
            \MoonShine\UI\Fields\Text::make('Precio', 'price'),
            \MoonShine\UI\Fields\Text::make('Stock', 'stock'),
            \MoonShine\UI\Fields\Text::make('Categoría', 'category.name'),
            \MoonShine\UI\Fields\Text::make('Proveedor', 'supplier.name'),
        ];
    }

    /**
     * @param Product $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ];
    }

    protected function search(): array
    {
        return ['id', 'name',];
    }
    protected function filters(): iterable
    {
        return [
            \MoonShine\Laravel\Fields\Relationships\BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class,
            )->valuesQuery(static fn(\Illuminate\Contracts\Database\Eloquent\Builder $q) => $q->select(['id', 'name'])),
            \MoonShine\Laravel\Fields\Relationships\BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class,
            )->valuesQuery(static fn(\Illuminate\Contracts\Database\Eloquent\Builder $q) => $q->select(['id', 'name'])),
        ];
    }
}
