<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductEditLayout extends Rows
{

    public function fields(): array
    {
        return [
            Input::make('product.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            TextArea::make('product.description')
                ->required()
                ->title(__('Description'))
                ->placeholder(__('Description'))
                ->rows(7),

            Input::make('product.price')
                ->type('number')
                ->max(1000000)
                ->required()
                ->title(__('Price'))
                ->placeholder(__('Price')),
        ];
    }
}
