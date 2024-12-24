<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\User;
use App\Observers\OrderObserver;
use App\Observers\OrderPositionObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
//        Order::observe(OrderObserver::class);
//        OrderPosition::observe(OrderPositionObserver::class);

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('yandex', \SocialiteProviders\Yandex\Provider::class);
        });

        Dashboard::useModel(
            \Orchid\Platform\Models\User::class,
            User::class
        );
    }
}
