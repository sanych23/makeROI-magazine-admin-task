<?php

namespace App\Orchid\Screens\Product;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use App\Orchid\Layouts\Product\ProductListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProductScreen extends Screen
{
    public $name = "Список продуктов";
    public $description = "Products this store";

    public function query(): iterable
    {
        return [
            'products' => Product::paginate(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить продукт')
                ->modal('editProductModal')
                ->method('createProduct')
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductListLayout::class,

            Layout::modal('editProductModal', ProductEditLayout::class)
                ->deferred('loadProductOnOpenModal')->title("Edit Product"),
        ];
    }

    public function saveProduct(ProductUpdateRequest $request, Product $product): void
    {
        $product->update($request->validated());

    }

    public function removeProduct(Request $request): void
    {
        Product::findOrFail($request->get('id'))->delete();
        Toast::info(__('Product was removed'));
    }

    public function createProduct(ProductCreateRequest $request)
    {
        Product::create($request->validated());
    }

    public function loadProductOnOpenModal(?Product $product): iterable
    {
        if($product){
            return [
                'product' => $product,
            ];
        }

        return [];
    }
}
