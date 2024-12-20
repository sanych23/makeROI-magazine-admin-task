<?php

namespace App\Http\Resources;

use App\Enums\OrderStatusType;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'status' => $this->status,
            'status_description' => $this->status->description,
            'positions' => $this->whenLoaded('positions', fn() => OrderPositionResource::collection($this->positions)),
        ];
    }
}
