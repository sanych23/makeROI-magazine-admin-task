<?php

namespace App\libs;


use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use App\Enums\OrderStatusType;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Services\ClientAMO;
use Illuminate\Support\Facades\Log;

class SynchronizeStatusAMO
{
    const STATUSES = [
        OrderStatusType::REGISTRATION => 72744466,
        OrderStatusType::DELIVERY => 72744470,
        OrderStatusType::SUCCESS => 142,
    ];

    public static function leadStatus(Order $order)
    {
        if(!isset($order->amo_id)){
            return;
        }

        $leadService = ClientAMO::makeClient()->leads();
        $leadService->updateOne((new LeadModel())
            ->setId($order->amo_id)
            ->setStatusId(self::STATUSES[$order->status->key])
        );
    }

    public static function orderStatus(int $status_id, int $lead_id)
    {
        $order = Order::where('amo_id', $lead_id)->first();
        if(!$order){
            Log::info('thats object not found!');
            return false;
        }


        $order->status = OrderStatusType::getKey(array_search($status_id, self::STATUSES));
        $order->save();
        return true;
    }
}
