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
use App\Modules\Payments\Models\Invoice;
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
        $faker = Faker::create();

        $languages = collect([
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Arabic', 'code' => 'ar'],
        ])->mapWithKeys(fn(array $language) => [
                $language['code'] => Language::updateOrCreate(
                    ['code' => $language['code']],
                    $language,
                ),
            ]);

        $currencies = collect([
            ['name' => 'US Dollar', 'code' => 'USD'],
            ['name' => 'Saudi Riyal', 'code' => 'SAR'],
            ['name' => 'UAE Dirham', 'code' => 'AED'],
        ])->mapWithKeys(fn(array $currency) => [
                $currency['code'] => Currency::updateOrCreate(
                    ['code' => $currency['code']],
                    $currency,
                ),
            ]);

        $paymentProviders = collect(['Stripe', 'PayPal', 'Payoneer', 'Tap'])->map(
            fn(string $name) => PaymentProvider::updateOrCreate(['name' => $name], ['name' => $name]),
        );

        $countries = collect();
        $countryCityData = [
            [
                'name' => 'Saudi Arabia',
                'code' => 'SA',
                'cities' => ['Riyadh', 'Jeddah', 'Dammam'],
            ],
            [
                'name' => 'United Arab Emirates',
                'code' => 'AE',
                'cities' => ['Dubai', 'Abu Dhabi', 'Sharjah'],
            ],
            [
                'name' => 'Egypt',
                'code' => 'EG',
                'cities' => ['Cairo', 'Alexandria', 'Giza'],
            ],
        ];

        foreach ($countryCityData as $countryData) {
            $country = Country::updateOrCreate(
                ['code' => $countryData['code']],
                ['name' => $countryData['name'], 'code' => $countryData['code']],
            );

            collect($countryData['cities'])->each(function (string $city) use ($country) {
                City::updateOrCreate(
                    ['name' => $city, 'country_id' => $country->id],
                    ['name' => $city, 'country_id' => $country->id],
                );
            });

            $countries->push($country);
        }

        $cities = City::whereIn('country_id', $countries->pluck('id'))->get();

        $categories = collect([
            [
                'name' => 'Electronics',
                'description' => 'Smart devices, accessories, and gadgets.',
            ],
            [
                'name' => 'Digital Services',
                'description' => 'Online subscriptions, hosting, and SaaS products.',
            ],
            [
                'name' => 'Education',
                'description' => 'Courses, workshops, and learning materials.',
            ],
        ])->map(fn(array $category) => Category::updateOrCreate(
                ['name' => $category['name'], 'language_id' => $languages['en']->id],
                [
                    'description' => $category['description'],
                    'language_id' => $languages['en']->id,
                    // 'image' => 'https://picsum.photos/seed/' . Str::slug($category['name']) . '/640/480',
                ],
            ));

        $products = collect();
        foreach ($categories as $category) {
            foreach (range(1, 4) as $index) {
                $country = $countries->random();
                $city = $country->cities()->inRandomOrder()->first() ?? $cities->random();
                $currency = $currencies->values()->random();
                $language = $languages->values()->random();
                $quantity = $faker->numberBetween(20, 150);
                $quantitySold = $faker->numberBetween(0, max(1, $quantity - 5));

                $products->push(
                    Product::factory()
                        ->for($category)
                        ->for($language, 'language')
                        ->for($currency, 'currency')
                        ->for($country, 'country')
                        ->for($city, 'city')
                        ->create([
                            'name' => $faker->unique()->words(3, true),
                            'price' => $faker->randomFloat(2, 30, 900),
                            'quantity' => $quantity,
                            'quantity_sold' => $quantitySold,
                            'discount' => $faker->numberBetween(0, 20),
                            'is_quantity_finished' => $quantitySold >= $quantity,
                        ]),
                );
            }
        }

        $defaultCountry = $countries->first();
        $defaultCity = $defaultCountry->cities()->first() ?? $cities->first();
        $defaultCurrency = $currencies->get('USD') ?? $currencies->values()->first();
        $defaultLanguage = $languages->get('en') ?? $languages->first();

        $admin = User::factory()
            ->admin()
            ->withPassword('Admin@123')
            ->withTwoFactor()
            ->for($defaultLanguage, 'language')
            ->for($defaultCurrency, 'currency')
            ->for($defaultCountry, 'country')
            ->for($defaultCity, 'city')
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'image' => null,
            ]);

        $users = User::factory()
            ->count(8)
            ->state(function () use ($languages, $currencies, $countries, $cities) {
                $country = $countries->random();
                $city = $country->cities()->inRandomOrder()->first() ?? $cities->first();

                return [
                    'language_id' => $languages->values()->random()->id,
                    'currency_id' => $currencies->values()->random()->id,
                    'country_id' => $country->id,
                    'city_id' => $city->id,
                    'image' => null,
                ];
            })
            ->create();

        $allUsers = $users->push($admin);
        $orders = collect();

        foreach ($allUsers as $user) {
            foreach (range(1, 2) as $loopIndex) {
                $product = $products->random();
                $quantity = $faker->numberBetween(1, 3);
                $gross = $product->price * $quantity;
                $amount = round(max(1, $gross - $product->discount), 2);
                $paymentProvider = $paymentProviders->random();
                $orderStatus = $faker->randomElement([
                    OrderStatus::PENDING,
                    OrderStatus::PROCESSING,
                    OrderStatus::COMPLETED,
                ]);

                $order = Order::factory()
                    ->for($user)
                    ->for($product)
                    ->for($paymentProvider, 'paymentProvider')
                    ->create([
                        'quantity' => $quantity,
                        'amount' => $amount,
                        'status' => $orderStatus,
                        'transaction_id' => strtoupper(Str::random(12)),
                    ]);

                $paymentStatus = $orderStatus === OrderStatus::COMPLETED
                    ? PaymentStatus::COMPLETED
                    : PaymentStatus::PENDING;

                $payment = Payment::factory()
                    ->for($user)
                    ->for($order)
                    ->for($paymentProvider, 'paymentProvider')
                    ->create([
                        'amount' => $amount,
                        'status' => $paymentStatus,
                        'transaction_id' => 'PAY-' . strtoupper(Str::random(10)),
                    ]);

                $invoiceStatus = $paymentStatus === PaymentStatus::COMPLETED
                    ? InvoiceStatus::PAID
                    : InvoiceStatus::UNPAID;

                Invoice::factory()
                    ->for($user)
                    ->for($payment)
                    ->for($product->currency, 'currency')
                    ->create([
                        'invoice_number' => 'INV-' . now()->format('Ym') . '-' . str_pad((string) ($orders->count() + 1), 4, '0', STR_PAD_LEFT),
                        'amount' => $amount,
                        'status' => $invoiceStatus,
                        'due_date' => now()->addDays(10),
                        'issued_at' => now(),
                        'url_pdf' => 'https://example.test/invoices/' . Str::uuid(),
                    ]);

                $orders->push($order);
            }
        }
    }
}
