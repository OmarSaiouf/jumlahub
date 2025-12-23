<?php

namespace Database\Factories;

use App\Core\Enums\PaymentStatus;
use App\Core\Models\PaymentProvider;
use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Models\Payment;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
            'payment_provider_id' => null,
            'amount' => null,
            'status' => PaymentStatus::PENDING,
            'transaction_id' => fake()->uuid(),
            'metadata' => [
                'method' => fake()->randomElement(['card', 'wallet', 'bank_transfer']),
                'ip' => fake()->ipv4(),
            ],
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Payment $payment) {
            if ($payment->order) {
                $payment->user()->associate($payment->order->user);

                if (!$payment->payment_provider_id) {
                    $payment->paymentProvider()->associate($payment->order->paymentProvider ?? PaymentProvider::factory());
                }

                $payment->amount ??= $payment->order->amount;
            }
        })->afterCreating(function (Payment $payment) {
            $dirty = false;

            if ($payment->order && !$payment->user_id) {
                $payment->user()->associate($payment->order->user);
                $dirty = true;
            }

            if ($payment->order && !$payment->payment_provider_id) {
                $payment->paymentProvider()->associate($payment->order->paymentProvider);
                $dirty = true;
            }

            if ($payment->order && $payment->amount === null) {
                $payment->amount = $payment->order->amount;
                $dirty = true;
            }

            if ($dirty) {
                $payment->save();
            }
        });
    }
}
