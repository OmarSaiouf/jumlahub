<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Category;

class CategoryService
{
    public function all(array|null $filters = null, int $limit = 30, int $offset = 0)
    {
        $query = Category::query();
        if ($filters != null) {
            $query->filter($filters);  // returns Builder
        }
        if (isset($filters['language_id'])) {
            $query->where('language_id', $filters['language_id']);
        }
        
        $query->limit($limit)->offset($offset);

        return $query;
    }

    public function getById(string $id)
    {
        return Category::find($id);
    }

    public function getByIdWithProducts(string $id)
    {
        return Category::with(['products', 'products.currency', 'products.language', 'products.country', 'products.city'])
        ->find($id);
    }
}