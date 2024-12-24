<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusSynchronizeRequest;
use App\libs\SynchronizeStatusAMO;


class HookController extends Controller
{
    public function changeOrderStatus(StatusSynchronizeRequest $request)
    {
        $lead = $request->validated();
        if(SynchronizeStatusAMO::orderStatus($lead['status_id'],  $lead['lead_id'])){
            return response(['good'], 200);
        }
        return response(['bad'], 200);
    }
}
