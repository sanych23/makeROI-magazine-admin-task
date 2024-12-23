<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Models\User;
use App\Orchid\Layouts\Order\OrderListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
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
            ModalToggle::make('Создать новый заказ')
                ->modal('createOrderModal')
                ->method('createOrder')
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::modal('createOrderModal', Layout::rows([
                Relation::make()
                    ->fromModel(User::class, 'name')
                    ->title('Выберите заказчика')
            ]))
                ->title("Новый заказ"),

            OrderListLayout::class,
        ];
    }

    public function removeProduct(Request $request)
    {
        Order::findOrFail($request->get('id'))->delete();
        Toast::info(__('Order was removed'));
    }

    public function createOrder(Request $request)
    {
        Order::create(['user_id' => $request->name]);
    }
}
