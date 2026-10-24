<?php

namespace Dev\Telehub\Models;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Models\BotCustomer;

class Tenant extends BaseModel
{
    protected $table = 'telehub_tenants';

    protected static ?Tenant $current = null;

    public static function current(): ?Tenant
    {
        if (static::$current) {
            return static::$current;
        }

        if (! \Illuminate\Support\Facades\Auth::check()) {
            return null;
        }

        return static::$current = static::query()->where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
    }

    protected $fillable = [
        'user_id',
        'role_id',
        'username',
        'password',
        'email',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    protected $hidden = [
        'password',
    ];

    public static function booted(): void
    {
        static::addGlobalScope('tenant_access', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (\Illuminate\Support\Facades\Auth::check() && ! \Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
                $builder->where($builder->getQuery()->from . '.user_id', \Illuminate\Support\Facades\Auth::id());
            }
        });

        static::created(function (Tenant $tenant) {
            $tenant->syncToUser();
        });

        static::updated(function (Tenant $tenant) {
            if ($tenant->isDirty(['username', 'email', 'password', 'status'])) {
                $tenant->syncToUser();
            }
        });

        static::deleted(function (Tenant $tenant) {
            if ($tenant->user_id) {
                \Dev\ACL\Models\User::where('id', $tenant->user_id)->delete();
            }
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\Dev\ACL\Models\User::class, 'user_id');
    }

    public function syncToUser(): void
    {
        $role = $this->role_id ? \Dev\ACL\Models\Role::query()->find($this->role_id) : null;
        $permissions = $role ? $role->permissions : [];

        $userData = [
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => 'User',
            'last_name' => 'Tele',
            'permissions' => $permissions ?: [],
        ];

        if ($this->isDirty('password') || ! $this->user_id) {
            $userData['password'] = $this->password;
        }

        $user = \Dev\ACL\Models\User::query()
            ->where('id', $this->user_id)
            ->orWhere('email', $this->email)
            ->orWhere('username', $this->username)
            ->first();

        if ($user) {
            // Force update permissions from role
            $user->update($userData);
        } else {
            $user = \Dev\ACL\Models\User::query()->create($userData);
        }

        if ($this->role_id) {
            $user->roles()->sync([$this->role_id]);
        }

        // Always ensure relationship is correct
        if ($this->user_id != $user->id) {
            $this->user_id = $user->id;
            $this->saveQuietly();
        }

        if ($user->wasRecentlyCreated || ! \Dev\ACL\Models\Activation::query()->where('user_id', $user->id)->where('completed', true)->exists()) {
            // Auto activate if new or not activated
            $activation = \Dev\ACL\Models\Activation::query()->where('user_id', $user->id)->first() ?: new \Dev\ACL\Models\Activation();
            $activation->fill([
                'code' => \Illuminate\Support\Str::random(32),
                'completed' => true,
                'completed_at' => now(),
            ]);
            $activation->user_id = $user->id;
            $activation->save();
        }
    }

    public function botConfigs(): HasMany
    {
        return $this->hasMany(BotConfig::class, 'tenant_id');
    }

    public function botCustomers(): HasMany
    {
        return $this->hasMany(BotCustomer::class, 'tenant_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'tenant_id');
    }

    public function productItems(): HasMany
    {
        return $this->hasMany(ProductItem::class, 'tenant_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'tenant_id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'tenant_id');
    }
}