<?php

namespace App\Http\Requests\OrderPosition;

use Illuminate\Foundation\Http\FormRequest;

class OrderPositionCountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'numeric', 'exists:orders,id'],
            'product_id' => ['required', 'uuid', 'exists:products,id'],
            'count' => ['required', 'numeric'],
        ];
    }
}
