<?php

namespace App\Models;

use App\Enums\OrderStatusType;
use App\libs\SynchronizeStatusAMO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;


class Order extends Model
{
    use AsSource;

    protected $fillable = [
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => OrderStatusType::class
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orders_positions');
    }

    public function positions(): HasMany
    {
        return $this->HasMany(OrderPosition::class);
    }

    protected static function boot()
    {
        parent::boot();

        parent::updating(function (Order $order){
            if($order->isDirty('status')){
                SynchronizeStatusAMO::leadStatus($order);
            }
        });

        parent::creating(function (Order $order) {
            if (empty($order->status)) $order->status = OrderStatusType::REGISTRATION();
        });
    }
}
