<?php

namespace App\Services;
use App\Models\OrderPosition;


class OrderCountService
{
    static function add(int $orderId, string $productId, int $count): OrderPosition
    {
        $query = OrderPosition::query()
            ->where("order_id", $orderId)
            ->where("product_id", $productId);

        if ($query->exists()) {
            $query->increment('count', $count);
            return $query->first();
        } else {
            return OrderPosition::create([
                "product_id" => $productId,
                "order_id" => $orderId,
                "count" => $count
            ]);
        }
    }

    static function remove(int $orderId, string $productId, int $count): bool
    {
        $query = OrderPosition::query()
            ->where("order_id", $orderId)
            ->where("product_id", $productId);

        if($query->first()->count <= $count){
            $query->delete();
            return true;
        }
        else{
            $query->decrement('count', $count);
            return false;
        }
    }
}


