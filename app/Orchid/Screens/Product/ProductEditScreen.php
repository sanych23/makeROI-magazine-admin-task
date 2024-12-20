<?php

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductEditScreen extends Screen
{
    public $product;

    public function query(Product $product): iterable
    {
        return [
            'product' => $product
        ];
    }

    public function name(): ?string
    {
        return "Product: {$this->product->name}";
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Удалить'))
                ->icon('bs.trash3')
                ->confirm(__('Once the product is deleted, all of its resources and data will be permanently deleted. Before deleting product, please download any data or information that you wish to retain.'))
                ->method('remove'),

            Button::make(__('Сохранить'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(ProductEditLayout::class)
                ->title("Product Information"),
        ];
    }

    public function remove(Product $product)
    {
        $product->delete();
        Toast::info(__('Product was removed'));
        return redirect()->route('platform.products');
    }

    public function save(Product $product, Request $request)
    {
        $validator = Validator::make($request->product, [
            'name' => ['string'],
            'description' => ['string'],
            'price' => ['numeric']
        ]);

        if (!$validator->fails()) {
            $product->update($validator->validated());
        }
    }
}
