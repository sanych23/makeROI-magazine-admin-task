<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Order;
use App\Models\OrderPosition;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderListLayout extends Table
{
    protected $target = 'orders';

    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->align(TD::ALIGN_CENTER),
            TD::make('user', 'Имя заказчика')
                ->render(fn ($order) => ($order->user->name))
                ->align(TD::ALIGN_CENTER),
            TD::make('status', 'Статус')
                ->render(fn($order)=>($order->status->value))
                ->align(TD::ALIGN_CENTER),
            TD::make('Кол-во позиций')
                ->render(function (Order $order){
                    $res = 0;
                    foreach ($order->positions as $product){
                        $res = $res + $product->count;
                    }
                    return $res;
                })
                ->align(TD::ALIGN_CENTER),
            TD::make('Итого')->align(TD::ALIGN_CENTER)
                ->render((function (Order $order){
                    return $order->positions->map(fn(OrderPosition $position) => $position->count * $position->product->price)->sum();
                })),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('10%')
                ->render(fn (Order $order) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.orders.edit', $order->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->method('removeProduct', [
                                'id' => $order->id,
                            ]),
                    ])),
        ];
    }
}
