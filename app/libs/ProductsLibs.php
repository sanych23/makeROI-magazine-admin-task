<?php

namespace App\libs;

use Illuminate\Support\Collection;

class ProductsLibs
{
    static function getProductsString(Collection $products): string
    {
        return $products->pluck('name')->implode(', ');
    }
}
