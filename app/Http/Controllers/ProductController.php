<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return ['products' => ProductResource::collection(Product::all())];
    }


    public function store(ProductCreateRequest $request)
    {
        return ['product' => new ProductResource(Product::create($request->validated()))];
    }


    public function show(Product $product)
    {
        return ['product' => new ProductResource($product)];
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return [
            'status' => 'Success'
        ];
    }
}
