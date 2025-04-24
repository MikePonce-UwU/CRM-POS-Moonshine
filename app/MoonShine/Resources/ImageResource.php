<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<Image>
 */
class ImageResource extends ModelResource
{
    protected string $model = Image::class;

    // protected string $title = 'Images';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            \MoonShine\UI\Fields\Image::make('Imagen', 'url'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                // ID::make(),
                \MoonShine\UI\Fields\Image::make('Imagen', 'url')
                ->disk('products'),
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
            \MoonShine\UI\Fields\Image::make('Imagen', 'url'),
        ];
    }

    /**
     * @param Image $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'url' => 'required|image|max:2048',
        ];
    }
}
