<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPosition\OrderPositionCountRequest;
use App\Http\Resources\OrderPositionResource;
use App\Models\OrderPosition;
use App\services\OrderCountService;

class OrderPositionCountController extends Controller
{
    public function add(OrderPositionCountRequest $request){
        return new OrderPositionResource(OrderCountService::add($request->order_id, $request->product_id, $request->count));
    }

    public function remove(OrderPositionCountRequest $request){
        if(OrderCountService::remove($request->order_id, $request->product_id, $request->count)){
            return [
                "status" => "Product delete from order"
            ];
        }
        else{
            return new OrderPositionResource(OrderPosition::where('order_id', $request->order_id)->where('product_id', $request->product_id)->first());
        }
    }
}
