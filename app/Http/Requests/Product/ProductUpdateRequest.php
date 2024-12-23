<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function prepareForValidation()
    {
        if($this->product){
            $this->replace([
                "name" => $this->product['name'],
                "description" => $this->product['description'],
                "price" => $this->product['price']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            "name" => ["string", "max:150"],
            "description" => ["string", "max:255"],
            "price" => ["numeric"]
        ];
    }
}
