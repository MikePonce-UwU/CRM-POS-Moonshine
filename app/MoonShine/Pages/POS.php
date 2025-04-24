<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;

#[Icon('m.document-plus')]
// #[Group('Inventario')]
#[Order(1)]
class POS extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'POS (Punto de Ventas)';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
		return [];
	}
}
