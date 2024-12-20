<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use UsesUuid, AsSource;

    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    public $timestamps = false;

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_positions', 'product_id', 'order_id');
    }
}
