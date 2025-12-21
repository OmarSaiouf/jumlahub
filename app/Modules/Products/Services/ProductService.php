<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;

class ProductService
{
    public function all(array|null $filters = null, int $limit = 30, int $offset = 0)
    {
        $query = Product::query()->with(['category:id,name', 'currency:id,code,name', 'language:id,code,name', 'country:id,name,code', 'city:id,name']);
       
        if ($filters != null) {
            $query->filter($filters);
        }
        return $query->limit($limit)->offset($offset);

    }

    public function find(string|int $id)
    {
        return Product::find($id);
    }
}