<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return ["orders" => OrderResource::collection(Order::with(['positions', 'positions.product'])->get())];
    }


    public function store(OrderCreateRequest $request)
    {
        return ["order" => new OrderResource(Order::create($request->validated())->refresh())];
    }


    public function show(Order $order)
    {
        $order->load(['positions', 'positions.product']);

        return ["order" => new OrderResource($order)];
    }


    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());
        return ["order" => new OrderResource($order)];
    }
}
