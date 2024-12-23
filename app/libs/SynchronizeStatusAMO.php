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

//        dd($order->status->key);

        $leadService->updateOne((new LeadModel())
            ->setId($order->amo_id)
            ->setStatusId(self::STATUSES[$order->status->key])
//            ->setPrice($position->order->positions->map(fn(OrderPosition $position) => $position->count * $position->product->price)->sum())
//            ->setCustomFieldsValues((new CustomFieldsValuesCollection())
//                ->add((new TextCustomFieldValuesModel())
//                    ->setFieldId(768843)
//                    ->setValues((new TextCustomFieldValueCollection())
//                        ->add((new TextCustomFieldValueModel())
//                            ->setValue(ProductsLibs::getProductsString($position->order->positions->map(function ($position){
//                                return $position->product;
//                            })))
//                        )
//                    )
//                )
//            )
        );

    }
}
