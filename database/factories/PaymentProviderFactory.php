<?php

namespace Database\Factories;

use App\Core\Models\PaymentProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentProvider>
 */
class PaymentProviderFactory extends Factory
{
    protected $model = PaymentProvider::class;

    public function definition(): array
    {
        $providers = ['Stripe', 'PayPal', 'Square', 'Adyen', 'Checkout', 'Payoneer'];

        return [
            'name' => fake()->unique()->randomElement($providers),
        ];
    }
}
