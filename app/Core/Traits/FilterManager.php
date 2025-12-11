<?php

namespace App\Core\Traits;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait FilterManager
{
    /**
     * Apply an array of filters to the query.
     *
     * Each filter key must be declared in $filterable on the model (or fall back to $fillable).
     * Supported shapes:
     *  - 'status' => 'paid'            (where)
     *  - 'status' => ['paid','new']    (whereIn)
     *  - 'amount' => ['from'=>10,'to'=>50] (range)
     *  - 'amount' => ['operator'=>'>=','value'=>10] (custom operator)
     *  - 'search' => 'abc'             (LIKE on $searchable columns)
     *  - Closures in $filterable allow fully custom behavior.
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (empty($filters)) {
            return $query;
        }

        $filterable = $this->getFilterableColumns();

        foreach ($filters as $key => $value) {
            if ($this->shouldSkip($value)) {
                continue;
            }

            if ($this->isSearchFilter($key)) {
                $this->applySearch($query, (string) $value);
                continue;
            }

            if (!array_key_exists($key, $filterable)) {
                continue;
            }

            $this->runFilter($query, $key, $value, $filterable[$key]);
        }

        return $query;
    }

    protected function runFilter(Builder $query, string $key, mixed $value, mixed $definition): void
    {
        if ($definition instanceof Closure) {
            $definition($query, $value);
            return;
        }

        $column = $this->resolveColumn($key, $definition);

        if (is_array($value)) {
            $this->applyArrayFilter($query, $column, $value);
            return;
        }

        if (is_string($value) && str_contains($value, '%')) {
            $this->applyLike($query, $column, $value, false, false);
            return;
        }

        $this->applyWhere($query, $column, '=', $value);
    }

    protected function applyArrayFilter(Builder $query, string $column, array $value): void
    {
        if (array_key_exists('from', $value) || array_key_exists('to', $value)) {
            $from = $value['from'] ?? null;
            $to = $value['to'] ?? null;

            if ($from !== null && $to !== null) {
                $this->applyBetween($query, $column, [$from, $to]);
            } elseif ($from !== null) {
                $this->applyWhere($query, $column, '>=', $from);
            } elseif ($to !== null) {
                $this->applyWhere($query, $column, '<=', $to);
            }
            return;
        }

        if (array_key_exists('between', $value) && is_array($value['between']) && count($value['between']) === 2) {
            $this->applyBetween($query, $column, array_values($value['between']));
            return;
        }

        if (array_key_exists('operator', $value) && array_key_exists('value', $value)) {
            $operator = $this->normalizeOperator((string) $value['operator']);
            $this->applyWhere($query, $column, $operator, $value['value']);
            return;
        }

        $clean = array_values(array_filter(
            $value,
            static fn ($item) => $item !== null && $item !== ''
        ));

        if (empty($clean)) {
            return;
        }

        $this->applyIn($query, $column, $clean);
    }

    protected function applySearch(Builder $query, string $term): void
    {
        $columns = $this->getSearchableColumns();

        if (empty($columns)) {
            return;
        }

        $query->where(function (Builder $builder) use ($columns, $term) {
            foreach ($columns as $index => $column) {
                $this->applyLike($builder, $column, $term, $index > 0);
            }
        });
    }

    protected function applyWhere(Builder $query, string $column, string $operator, mixed $value, bool $useOr = false): void
    {
        $method = $useOr ? 'orWhere' : 'where';

        if (str_contains($column, '.')) {
            [$relation, $relatedColumn] = explode('.', $column, 2);
            $query->{$useOr ? 'orWhereHas' : 'whereHas'}($relation, function (Builder $builder) use ($relatedColumn, $operator, $value) {
                $builder->where($relatedColumn, $operator, $value);
            });
            return;
        }

        $query->{$method}($column, $operator, $value);
    }

    protected function applyBetween(Builder $query, string $column, array $range, bool $useOr = false): void
    {
        $method = $useOr ? 'orWhereBetween' : 'whereBetween';

        if (str_contains($column, '.')) {
            [$relation, $relatedColumn] = explode('.', $column, 2);
            $query->{$useOr ? 'orWhereHas' : 'whereHas'}($relation, function (Builder $builder) use ($relatedColumn, $range) {
                $builder->whereBetween($relatedColumn, $range);
            });
            return;
        }

        $query->{$method}($column, $range);
    }

    protected function applyIn(Builder $query, string $column, array $values, bool $useOr = false): void
    {
        $method = $useOr ? 'orWhereIn' : 'whereIn';

        if (str_contains($column, '.')) {
            [$relation, $relatedColumn] = explode('.', $column, 2);
            $query->{$useOr ? 'orWhereHas' : 'whereHas'}($relation, function (Builder $builder) use ($relatedColumn, $values) {
                $builder->whereIn($relatedColumn, $values);
            });
            return;
        }

        $query->{$method}($column, $values);
    }

    protected function applyLike(Builder $query, string $column, string $value, bool $useOr = false, bool $autoWrap = true): void
    {
        $term = $autoWrap && !str_contains($value, '%')
            ? '%' . $value . '%'
            : $value;

        $method = $useOr ? 'orWhere' : 'where';

        if (str_contains($column, '.')) {
            [$relation, $relatedColumn] = explode('.', $column, 2);
            $query->{$useOr ? 'orWhereHas' : 'whereHas'}($relation, function (Builder $builder) use ($relatedColumn, $term) {
                $builder->where($relatedColumn, 'like', $term);
            });
            return;
        }

        $query->{$method}($column, 'like', $term);
    }

    protected function resolveColumn(string $key, mixed $definition): string
    {
        if (is_array($definition) && array_key_exists('column', $definition) && is_string($definition['column'])) {
            return $definition['column'];
        }

        if (is_string($definition) && $definition !== '') {
            return $definition;
        }

        return $key;
    }

    protected function getFilterableColumns(): array
    {
        if (property_exists($this, 'filterable') && is_array($this->filterable)) {
            return $this->filterable;
        }

        if (property_exists($this, 'fillable') && is_array($this->fillable)) {
            $fillable = array_combine($this->fillable, $this->fillable);
            return $fillable === false ? [] : $fillable;
        }

        return [];
    }

    protected function getSearchableColumns(): array
    {
        return property_exists($this, 'searchable') && is_array($this->searchable)
            ? $this->searchable
            : [];
    }

    protected function isSearchFilter(string $key): bool
    {
        $searchKey = property_exists($this, 'searchKey') && is_string($this->searchKey)
            ? $this->searchKey
            : 'search';

        return $key === $searchKey && !empty($this->getSearchableColumns());
    }

    protected function normalizeOperator(string $operator): string
    {
        $operator = strtolower(trim($operator));

        $allowed = ['=', '!=', '<>', '>', '>=', '<', '<=', 'like'];

        return in_array($operator, $allowed, true) ? $operator : '=';
    }

    protected function shouldSkip(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (!is_array($value)) {
            return false;
        }

        return count(array_filter(
            $value,
            static fn ($item) => $item !== null && $item !== ''
        )) === 0;
    }
}
