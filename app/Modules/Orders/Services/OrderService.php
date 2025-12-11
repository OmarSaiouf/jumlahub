<?php

namespace App\Modules\Orders\Services;

use App\Modules\Orders\Models\Order;


class OrderService
{
    public function all(array|null $filters, int $limit = 30, int $offset = 0)
    {   
        $query = Order::query();
        if($filters !=null ){
            $query->filter();
        }
    }

}