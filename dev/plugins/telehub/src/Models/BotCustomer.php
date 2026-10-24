<?php

namespace Dev\Telehub\Models;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Dev\Telehub\Models\BalanceLog;
use Dev\Telehub\Models\DepositRequest;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\Tenant;

class BotCustomer extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_bot_customers';

    protected $fillable = [
        'tenant_id',
        'telegram_id',
        'full_name',
        'balance',
        'status',
        'api_key',
        'is_dealer',
        'language',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function balanceLogs(): HasMany
    {
        return $this->hasMany(BalanceLog::class, 'customer_id');
    }

    public function depositRequests(): HasMany
    {
        return $this->hasMany(DepositRequest::class, 'customer_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 0, ',', '.') . ' ₫';
    }
}
