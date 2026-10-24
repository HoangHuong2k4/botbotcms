<?php

namespace Dev\Telehub\Traits;

use Dev\Telehub\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasTenant
{
    public static function bootHasTenant(): void
    {
        static::creating(function ($model) {
            if (! $model->tenant_id && Auth::check() && ! Auth::user()?->isSuperUser()) {
                if ($tenant = Tenant::current()) {
                    $model->tenant_id = $tenant->id;
                }
            }
        });

        static::addGlobalScope('tenant_scope', function (Builder $builder) {
            if (Auth::check() && ! Auth::user()->isSuperUser()) {
                if ($tenant = Tenant::current()) {
                    $builder->where($builder->getQuery()->from . '.tenant_id', $tenant->id);
                } else {
                    // Force no results if no tenant found for non-super-user
                    $builder->whereRaw('1 = 0');
                }
            }
        });
    }

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
