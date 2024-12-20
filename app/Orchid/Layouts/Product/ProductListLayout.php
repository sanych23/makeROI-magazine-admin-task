<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    protected $target = 'products';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Наименование'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => ModalToggle::make($product->name)
                ->modal('editProductModal')
                ->method('saveProduct')
                ->asyncParameters([
                    'product' => $product->id,
                ])),
            TD::make('description', 'Описание'),
            TD::make('price', 'Цена')->width('10%'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('10%')
                ->render(fn (Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.products.edit', $product->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->method('removeProduct', [
                                'id' => $product->id,
                            ]),
                    ])),
        ];
    }
}
