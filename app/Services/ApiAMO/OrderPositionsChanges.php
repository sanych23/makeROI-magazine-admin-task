<?php

namespace App\Services\ApiAMO;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use App\libs\ProductsLibs;
use App\Models\OrderPosition;
use App\Services\ClientAMO;

class OrderPositionsChanges
{
    public static function addProductToLead(OrderPosition $position)
    {
        if(!isset($position->order->amo_id)){
            return;
        }

        $leadService = ClientAMO::makeClient()->leads();

        $leadService->updateOne((new LeadModel())
                ->setId($position->order->amo_id)
                ->setPrice($position->order->positions->map(fn(OrderPosition $position) => $position->count * $position->product->price)->sum())
                ->setCustomFieldsValues((new CustomFieldsValuesCollection())
                    ->add((new TextCustomFieldValuesModel())
                        ->setFieldId(768843)
                        ->setValues((new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                                ->setValue(ProductsLibs::getProductsString($position->order->positions->map(function ($position){
                                    return $position->product;
                                })))
                            )
                        )
                    )
                )
            );
    }
}


