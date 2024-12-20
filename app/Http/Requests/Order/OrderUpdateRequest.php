<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatusType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["uuid", "exists:users,id"],
            "status" => [new EnumValue(OrderStatusType::class)],
        ];
    }
}
