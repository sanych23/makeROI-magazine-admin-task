<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Models\Product;
use App\Orchid\Layouts\Order\OrderListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class OrderListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'orders' => Order::paginate()
        ];
    }

    public function name(): ?string
    {
        return 'Список заказов';
    }

    public function commandBar(): iterable
    {
        return [

        ];
    }

    public function layout(): iterable
    {
        return [
            OrderListLayout::class,
        ];
    }

    public function removeProduct(Request $request)
    {
        Order::findOrFail($request->get('id'))->delete();
        Toast::info(__('Order was removed'));
    }
}
