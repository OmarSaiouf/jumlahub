<?php

namespace App\Modules\Invoices\Models;

use App\Core\Enums\InvoiceStatus;
use App\Core\Models\Currency;
use App\Modules\Payments\Models\Payment;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'payment_id',
        'invoice_number',
        'amount',
        'currency_id',
        'status',
        'due_date',
        'issued_at',
        'metadata',
        'url_pdf',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'due_date' => 'date',
        'issued_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
