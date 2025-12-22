<?php

namespace App\Modules\Products\Models;

use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Core\Scopes\ActiveScope;
use App\Core\Scopes\FilterScope;
use App\Core\Traits\FilterManager;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasUuids, FilterManager;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit',
        'quantity',
        'quantity_sold',
        'discount',
        'is_quantity_finished',
        'category_id',
        'language_id',
        'image',
        'country_id',
        'city_id',
        'currency_id',
    ];

    protected array $filterable = [
        'name',
        'description',
        'price',
        'unit',
        'quantity',
        'quantity_sold',
        'discount',
        'is_quantity_finished',
        'category_id',
        'language_id',
        'country_id',
        'city_id',
        'currency_id',
    ];

    protected array $searchable = [
        'name',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'quantity_sold' => 'integer',
        'discount' => 'integer',
        'is_quantity_finished' => 'boolean',
    ];


    protected static function booted(): void
    {
        static::addGlobalScope(new FilterScope);
        static::addGlobalScope(new ActiveScope);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Ensure the factory is resolved correctly from the custom module namespace.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ProductFactory::new();
    }
}
