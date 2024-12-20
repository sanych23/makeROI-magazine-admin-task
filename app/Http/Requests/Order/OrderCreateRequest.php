<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatusType;
use BenSampo\Enum\Rules\EnumValue;
use Dotenv\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["required", "uuid", "exists:users,id"],
            "status" => [new EnumValue(OrderStatusType::class)],
        ];
    }
}
