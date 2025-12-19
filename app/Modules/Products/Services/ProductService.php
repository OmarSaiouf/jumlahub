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
        $query->select('id', 'name', 'price', 'unit', 'quantity', 'quantity_sold', 'image', "category_id", "language_id", "currency_id", "discount", 'is_quantity_finished')
            ->with(['category:id,name']);
        $query->limit($limit)->offset($offset);

        return $query;
    }

    public function find(string|int $id)
    {
        return Product::find($id);
    }
}