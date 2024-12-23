<?php

namespace App\Services;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;

class ClientAMO
{
    static function makeClient(): AmoCRMApiClient
    {
        $accessToken = env('AMO_TOKEN');
        $apiClient = new AmoCRMApiClient();
        $longLivedAccessToken = new LongLivedAccessToken($accessToken);
        $apiClient->setAccessToken($longLivedAccessToken)
            ->setAccountBaseDomain('asanochkin23.amocrm.ru');
        return $apiClient;
    }
}
