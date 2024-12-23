<?php

namespace App\Orchid\Screens\Order;

use App\Enums\OrderStatusType;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\Product;
use App\Services\OrderCountService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderEditScreen extends Screen
{
    public $order;

    public function query(Order $order): iterable
    {
        return [
            'order' => $order,
            'positions' => $order->positions
        ];
    }

    public function name(): ?string
    {
        return 'Редактирование заказа';
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить продукт в заказ')
                ->modal('orderPositionAddProduct')
                ->method('addProductToOrder')
                ->icon('plus'),
        ];
    }

    public function getAllProducts()
    {
        $res = [];
        foreach(Product::all() as $product){
            $res[$product->id] = $product->name;
        }
        return $res;
    }

    public function layout(): iterable
    {
        return [
            Layout::modal('orderPositionAddProduct', Layout::rows([
                Matrix::make('matrix')
                    ->columns([
                        'Наименование продукта',
                        'Кол-во продукта',
                    ])
                    ->fields([
                        'Наименование продукта' => Select::make()
                            ->options($this->getAllProducts())
                            ->required(),
                        'Кол-во продукта' => Input::make()
                            ->type('number')
                            ->required()
                    ]),
            ]))->deferred('loadAllProducts')->title("Редактирование заказа"),

            Layout::block(
                Layout::rows([
                    Label::make('order.user.name')->title('Имя покупателя'),
                    Label::make('order.user.email')->title('Email'),
                    Label::make('order.user.phone')->title('Phone')
                ])
            )->title('Покупатель')->description('Информация о покупателе'),


            Layout::block(
                Layout::rows([
                    Label::make()->title("Текущий статус: {$this->order->status->description}")->description("Ниже выберите поле на которое хотите поменять статус"),
                    Select::make('order.status.description')->options(OrderStatusType::asSelectArray()),
                    Button::make('Сохранить статус')->method('saveStatus')
                ])
            )->title("Cтатус")->description('Cтатус в котором находится заказ'),


            Layout::block(
                Layout::table('positions', [
                    TD::make(title:'Именование продукта')->render(function(OrderPosition $position){
                        return $position->product->name;
                    })->align(TD::ALIGN_CENTER),
                    TD::make(title:'Цена товара')->render(function (OrderPosition $position){
                        return $position->product->price." руб.";
                    })->align(TD::ALIGN_CENTER),
                    TD::make(title:'Кол-во товара')->render(function (OrderPosition $position){
                        return $position->count;
                    })->align(TD::ALIGN_CENTER),
                    TD::make(title:'Итого')->render(function (OrderPosition $position){
                        return $position->count * $position->product->price." руб.";
                    }),

                    TD::make()
                        ->align(TD::ALIGN_CENTER)
                        ->width('10%')
                        ->render(fn (OrderPosition $position) => Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->method('removeOrder', [
                                'position' => $position->id,
                            ])),
                ])
            )->title("Продукты")->description('Продукты добавленные в заказ'),
        ];
    }

    public function removeOrder(OrderPosition $position)
    {
        $position->delete();
        Toast::info(__('Продукт удален из заказа'));
    }

    public function addProductToOrder(Request $request)
    {
        array_walk($request->all()['matrix'], function($data){
            OrderCountService::add($this->order->id , $data['Наименование продукта'], $data['Кол-во продукта']);
        });
    }

    public function saveStatus(Request $request)
    {
        $this->order->status = $request->order['status']['description'];
        $this->order->save();
    }

    public function loadAllProducts()
    {
        return [
            'products' => Product::all()
        ];
    }
}
