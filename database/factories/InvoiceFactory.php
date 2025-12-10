<?php

namespace Database\Factories;

use App\Core\Enums\InvoiceStatus;
use App\Core\Models\Currency;
use App\Modules\Payments\Models\Invoice;
use App\Modules\Payments\Models\Payment;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $issuedAt = fake()->dateTimeBetween('-7 days', 'now');

        return [
            'user_id' => User::factory(),
            'payment_id' => Payment::factory(),
            'invoice_number' => strtoupper(Str::random(3)) . '-' . fake()->unique()->numerify('#####'),
            'amount' => null,
            'currency_id' => Currency::factory(),
            'status' => InvoiceStatus::UNPAID,
            'due_date' => fake()->dateTimeBetween($issuedAt, '+30 days'),
            'issued_at' => $issuedAt,
            'metadata' => [
                'note' => fake()->sentence(),
            ],
            'url_pdf' => fake()->optional()->url(),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Invoice $invoice) {
            if ($invoice->payment) {
                $invoice->user()->associate($invoice->payment->user);
                $invoice->amount ??= $invoice->payment->amount;

                if (!$invoice->currency_id && $invoice->payment->order?->product?->currency_id) {
                    $invoice->currency_id = $invoice->payment->order->product->currency_id;
                }
            }
        })->afterCreating(function (Invoice $invoice) {
            $dirty = false;

            if ($invoice->payment && !$invoice->user_id) {
                $invoice->user()->associate($invoice->payment->user);
                $dirty = true;
            }

            if ($invoice->payment && $invoice->amount === null) {
                $invoice->amount = $invoice->payment->amount;
                $dirty = true;
            }

            if (
                $invoice->payment &&
                !$invoice->currency_id &&
                $invoice->payment->order?->product?->currency_id
            ) {
                $invoice->currency_id = $invoice->payment->order->product->currency_id;
                $dirty = true;
            }

            if ($dirty) {
                $invoice->save();
            }
        });
    }
}
