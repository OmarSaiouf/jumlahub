<?php

namespace App\Modules\Products\Services;

use App\Core\Enums\FilterSort;
use App\Core\Enums\FilterStatus;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use SebastianBergmann\CodeCoverage\Filter;

class ProductService
{
    public function all(array|null $filters = null, int $limit = 30, int $offset = 0): Builder
    {
        $query = Product::query()->with(['category:id,name', 'currency:id,code,name', 'language:id,code,name', 'country:id,name,code', 'city:id,name']);

        if ($filters) {
            if (isset($filters['sort'])) {
                $query = FilterSort::getEnum($filters['sort'])->get($query);
            }
            if (isset($filters['status'])) {
                $query = FilterStatus::getEnum($filters['status'])->get($query);
            }
            if (isset($filters['q'])) {
                $query->where('name', 'like', '%' . $filters['q'] . '%');
            }
        }
        // if ($filters != null) {
        //     $query->filter($filters);
        // }
        return $query->limit($limit)->offset($offset);

    }

    public function find(string|int $id)
    {
        return Product::find($id);
    }
}