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
        $query->limit($limit)->offset($offset);

        return $query;
    }

    public function getById(string $id)
    {
        return Category::find($id);
    }
}