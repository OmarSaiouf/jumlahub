<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;

class ProductService
{
    public function all(array|null $filters, int $limit = 30, int $offset = 0)
    {
        $query = Product::query();
        if ($filters != null) {
            $query->filter($filters);
        }
        $query->limit($limit)->offset($offset);

        return $query;
    }
}