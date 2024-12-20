<?php

namespace App\Orchid\Screens\Product;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use App\Orchid\Layouts\Product\ProductListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
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
                ->modal('productCreateModal')
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

            Layout::modal('productCreateModal', Layout::rows([
                Input::make('name')
                    ->title('Name')
                    ->placeholder('Enter product name')
                    ->help('The name of the product to be created.'),
                Input::make('description')
                    ->title('Description')
                    ->placeholder('Enter product description'),
                Input::make('price')
                    ->title('Price')
                    ->placeholder('Enter product price'),
            ]))
                ->title('Create Product')
                ->applyButton('Add Product'),
        ];
    }



    public function saveProduct(Request $request, Product $product): void
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

    public function removeProduct(Request $request): void
    {
        Product::findOrFail($request->get('id'))->delete();
        Toast::info(__('Product was removed'));
    }

    public function createProduct(ProductCreateRequest $request)
    {
        Product::create($request->validated());
    }

    public function loadProductOnOpenModal(Product $product): iterable
    {
        return [
            'product' => $product,
        ];
    }
}
