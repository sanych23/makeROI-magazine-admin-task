<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPositionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order" => new OrderResource($this->order),
            "product" => new ProductResource($this->product),
            "count" => $this->count
        ];
    }
}
