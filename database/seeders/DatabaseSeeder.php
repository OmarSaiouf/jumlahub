<?php

namespace Database\Seeders;

use App\Core\Enums\InvoiceStatus;
use App\Core\Enums\OrderStatus;
use App\Core\Enums\PaymentStatus;
use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Core\Models\PaymentProvider;
use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Gateways\PaypalGateway;
use App\Modules\Payments\Models\Payment;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use App\Modules\Users\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $languages = [
            'ar' => 'العربية',
            'en' => 'الإنجليزية',
            'tr' => 'التركية',
        ];

        $currencies = [
            'USD' => 'الدولار الأمريكي',
            'EUR' => 'اليورو',
            'SYP' => 'الليرة السورية',
        ];

        $countries = [
            'eg' => 'مصر',
            'sy' => 'سوريا',
            'jo' => 'الأردن',
        ];

        $cities = [
            'eg' => [
                'القاهرة',
                'الجيزة',
                'الإسكندرية',
                'المنصورة',
                'أسيوط',
                'سوهاج',
                'الأقصر',
                'أسوان',
                'سيناء',
            ],
            'sy' => [
                'دمشق',
                'حلب',
                'حمص',
                'حماة',
                'اللاذقية',
                'طرطوس',
                'دير الزور',
                'الرقة',
                'السويداء',
            ],
            'jo' => [
                'عمّان',
                'إربد',
                'الزرقاء',
                'العقبة',
                'السلط',
                'الكرك',
                'المفرق',
                'معان',
                'الطفيلة',
            ],
        ];


        foreach ($currencies as $k => $v) {
            Currency::create([
                'name' => $v,
                "code" => $k
            ]);
        }
        foreach ($languages as $k => $v) {
            Language::create([
                'name' => $v,
                "code" => $k
            ]);
        }
        foreach ($countries as $k => $v) {
            $country = Country::create([
                "name" => $v,
                "code" => $k
            ]);
            if (isset($cities[$k])) {
                foreach ($cities[$k] as $v) {
                    City::create([
                        'country_id' => $country->id,
                        'name' => $v
                    ]);
                }
            }
        }

        $paymentProviders = [
            "paypal" => [
                "code" => "paypal",
                "gateway_class" => PaypalGateway::class,
                "config" => json_encode([
                    'live_url' => 'https://api-m.paypal.com',
                    "test_url" => 'https://api-m.sandbox.paypal.com',
                    "client_id" => env('PAYPAL_CLIENT_ID'),
                    "secret" => env('PAYPAL_CLIENT_SECRET'),
                    "cache_ttl" => 3600,
                    "webhook_id" => env('PAYPAL_WEBHOOK_ID'),
                    "is_test" => env('PAYPAL_IS_TEST', true)
                ]),
                "is_active" => true
            ]
        ];

        foreach ($paymentProviders as $k => $v) {
            PaymentProvider::create([
                "name" => $k,
                "code" => $v['code'],
                "config" => $v['config'],
                "gateway_class" => $v['gateway_class'],
                "is_active" => $v['is_active'],
            ]);
        }


    }
}
