<?php

namespace App\Observers;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Services\ClientAMO;

class OrderObserver
{
    public function created(Order $order): void
    {
        $leadService = ClientAMO::makeClient()->leads();

        $leadService->add((new LeadsCollection())
            ->add((new LeadModel())
                ->setPipelineId(9029654)
                ->setName("Сделка №{$order->id}")
                ->setPrice($order->positions->map(fn(OrderPosition $position) => $position->count * $position->product->price)->sum())
                ->setResponsibleUserId(11883222)
                ->setCustomFieldsValues((new CustomFieldsValuesCollection())
//                    ->add((new TextCustomFieldValuesModel())
//                        ->setFieldId(768843)    // Products
//                        ->setValues((new TextCustomFieldValueCollection())
//                            ->add((new TextCustomFieldValueModel())
//                                ->setValue(ProductsLibs::getProductsString($order->positions->map(function ($position){
//                                    return $position->product;
//                                })))
//                            )
//                        )
//                    )
                    ->add((new TextCustomFieldValuesModel())
                        ->setFieldId(768845)    // Сustomer name
                        ->setValues((new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                                ->setValue($order->user->name)
                            )
                        )
                    )
                    ->add((new TextCustomFieldValuesModel())
                        ->setFieldId(768847)    // Customer Phone Number
                        ->setValues((new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                                ->setValue($order->user->phone)
                            )
                        )
                    )
                )
            ));
    }


    public function updated(Order $order): void
    {
        //
    }


    public function deleted(Order $order): void
    {
        //
    }


    public function restored(Order $order): void
    {
        //
    }


    public function forceDeleted(Order $order): void
    {
        //
    }
}