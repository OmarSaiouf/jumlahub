<?php

namespace App\Modules\Products\Models;

use App\Core\Models\Language;
use App\Core\Traits\FilterManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use FilterManager;

    protected $fillable = [
        'name',
        'parent_id',
        'language_id',
        'description',
        'image',
    ];
    protected array $filterable = [
        'name',
        'parent_id',
        'language_id',
        'description',
    ];

    protected array $searchable = [
        'name',
    ];


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
