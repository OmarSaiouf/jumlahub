<?php

namespace App\Modules\Orders\Services;

use App\Core\Enums\OrderStatus;
use App\Core\Scopes\ActiveScope;
use App\Core\Scopes\FilterScope;
use App\Modules\Orders\Events\OrderCreated;
use App\Modules\Orders\Models\Order;
use App\Modules\Products\Facades\ProductFacade;

use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function allForUser(string $user_id, array|null $filter = null, int $limit = 20, int $offset = 0)
    {
        $filters = [
            'user_id' => $user_id,
        ];
        if ($filter != null) {
            $filters = array_merge($filter);
        }
        $query = $this->get($filters)
            // ->where('user_id', $user_id)
            ->with([
                'product:id,name,image,currency_id',
                'product' => function ($q) {
                    $q->withoutGlobalScopes([FilterScope::class, ActiveScope::class]);
                },
                'product.currency:id,code',
            ])
            ->limit($limit)
            ->offset($offset);

        return $query;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $product = ProductFacade::find($data['product_id']);

            if ($product == null) {
                throw new Exception('product not found.');
            }

            if ($product['is_quantity_finished'] == true) {
                throw new Exception('The product stock has run out.');
            }

            $totalPrice = $data['quantity'] * $product['price'];
            $order = Order::create([
                ...$data,
                "amount" => $product['discount'] > 0 ? $totalPrice : $totalPrice * ($product['discount'] / 100),
                "status" => OrderStatus::PROCESSING->getValue()
            ]);


            // event(new CreatedOrder($order));
            OrderCreated::dispatch($order);

            return $order;
        });
    }

    public function check($orderId, $user_id)
    {
        $filters = [
            'user_id' => $user_id,
            "id" => $orderId
        ];
        return $this->get($filters)->exists();
    }


    public function find($orderId)
    {
        return Order::with([
            'product.currency:id,code',
            'product' => function ($q) {
                $q->withoutGlobalScopes([FilterScope::class, ActiveScope::class]);
            },
            'paymentProvider:id,name,code',
        ])->findOrFail($orderId);
    }

    private function get(array|null $filters = null)
    {
        $query = Order::query();
        if ($filters != null) {
            $query->filter($filters);
        }
        return $query;
    }


}
