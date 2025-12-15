<?php

namespace App\Modules\Payments\Services;

use App\Core\Models\PaymentProvider;

class PaymentGatewayFactory
{
    public static function make(string $providerCode)
    {
        $provider = PaymentProvider::query()
            ->where('code', $providerCode)
            ->where('is_active', true)
            ->firstOrFail();

        return app($provider->gateway_class, [
            'config' => $provider->config,
        ]);
    }
}