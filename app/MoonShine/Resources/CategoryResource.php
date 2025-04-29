<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

#[Icon('tag')]
// #[Group('Inventario')]
#[Order(1)]
/**
 * @extends ModelResource<Category>
 */
class CategoryResource extends ModelResource
{
    protected string $model = Category::class;

    protected string $title = 'Categorías';

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
            \MoonShine\UI\Fields\Text::make('Nombre', 'name')->sortable(),
            \MoonShine\UI\Fields\Number::make('Productos', 'products_count'),
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
                \MoonShine\UI\Fields\Text::make('Nombre', 'name')
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
            \MoonShine\UI\Fields\Text::make('Nombre', 'name'),
            \MoonShine\Laravel\Fields\Relationships\HasMany::make('Productos Disponibles', 'products', resource: ProductResource::class)
                ->relatedLink()
                ->fields([
                    \MoonShine\UI\Fields\Image::make('Imagen', 'image.url')
                        ->disk('products'),
                    \MoonShine\UI\Fields\Text::make('Nombre', 'name'),
                    \MoonShine\UI\Fields\Text::make('Descripción', 'description'),
                    \MoonShine\UI\Fields\Text::make('Precio', 'price'),
                    \MoonShine\UI\Fields\Text::make('Stock', 'stock'),
                ]),
        ];
    }

    /**
     * @param Category $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }


    protected function search(): array
    {
        return ['id', 'name'];
    }
}
