<?php

namespace Database\Factories;

use App\Core\Enums\OrderStatus;
use App\Core\Models\PaymentProvider;
use App\Modules\Orders\Models\Order;
use App\Modules\Products\Models\Product;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);

        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'payment_provider_id' => PaymentProvider::factory(),
            'amount' => null,
            'quantity' => $quantity,
            'status' => OrderStatus::PENDING,
            'transaction_id' => fake()->uuid(),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Order $order) {
            if ($order->amount === null && $order->product) {
                $order->amount = round($order->product->price * $order->quantity, 2);
            }
        })->afterCreating(function (Order $order) {
            if ($order->amount === null && $order->product) {
                $order->amount = round($order->product->price * $order->quantity, 2);
                $order->save();
            }
        });
    }
}
