<?php

namespace App\Observers;

use App\Models\OrderPosition;
use App\Services\ApiAMO\OrderPositionsChanges;

class OrderPositionObserver
{
    public function created(OrderPosition $orderPosition): void
    {
        OrderPositionsChanges::addProductToLead($orderPosition);
    }

   public function updated(OrderPosition $orderPosition): void
    {
        OrderPositionsChanges::addProductToLead($orderPosition);
    }

    public function deleted(OrderPosition $orderPosition): void
    {
        OrderPositionsChanges::addProductToLead($orderPosition);
    }
}
