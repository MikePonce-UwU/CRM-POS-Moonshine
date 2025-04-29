<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

#[Icon('user-plus')]
// #[Group('Inventario')]
#[Order(1)]
/**
 * @extends ModelResource<Customer>
 */
class CustomerResource extends ModelResource
{
    protected string $model = Customer::class;

    protected string $title = 'Customers';

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
            \MoonShine\UI\Fields\Text::make('E-mail', 'email')->sortable(),
            \MoonShine\UI\Fields\Text::make('Teléfono', 'phone'),
            \MoonShine\UI\Fields\Text::make('Dirección', 'address'),
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
                \MoonShine\UI\Fields\Text::make('E-mail', 'email'),
                \MoonShine\UI\Fields\Text::make('Teléfono', 'phone'),
                \MoonShine\UI\Fields\Text::make('Dirección', 'address'),
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
        ];
    }

    /**
     * @param Customer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
    protected function search(): array
    {
        return ['id', 'name',];
    }
}
