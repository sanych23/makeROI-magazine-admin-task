<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["string"],
            "description" => ["string"],
            "price" => ["numeric"]
        ];
    }
}
