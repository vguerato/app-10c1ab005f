<?php

namespace App\Repository\v1;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }
}
