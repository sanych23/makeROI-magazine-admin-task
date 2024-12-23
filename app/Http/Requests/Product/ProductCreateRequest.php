<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function prepareForValidation()
    {
        if($this->product){
            $this->mergeIfMissing([
                'name' => $this->product['name'],
                'description' => $this->product['description'],
                'price' => $this->product['price']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ];
    }
}
