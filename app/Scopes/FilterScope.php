<?php

namespace App\Scopes;

use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FilterScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('language_id', Language::where('code', app()->getLocale())->first()?->id)
            ->where('currency_id', Currency::where('code', app('currency'))->first()?->id);
            
        if (auth('web')->check()) {
            $builder->where('country_id', auth('web')->user()->country_id ?? "")
                ->where('city_id', auth('web')->user()->city_id ?? "");
        }
    }
}
