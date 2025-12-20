<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;

class ProductService
{
    public function all(array|null $filters = null, int $limit = 30, int $offset = 0)
    {
        $query = Product::query();
        if ($filters != null) {
            $query->filter($filters);
        }
        $query->with(['category:id,name', 'currency:id,code,name', 'language:id,code,name', 'country:id,name,code', 'city:id,name'])
            ->where('currency_id', $filters['currency_id'] ?? null)
            ->where('country_id', $filters['country_id'] ?? null)
            ->where('city_id', $filters['city_id'] ?? null)
            ->where('language_id', $filters['language_id'] ?? null);
        $query->limit($limit)->offset($offset);

        return $query;
    }

    public function find(string|int $id)
    {
        return Product::find($id);
    }
}