<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_orders';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'code',
        'total_amount',
        'status',
        'api_provider_id',
        'api_order_code',
        'api_response',
        'api_status',
    ];

    public function apiProvider(): BelongsTo
    {
        return $this->belongsTo(ApiProvider::class, 'api_provider_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(BotCustomer::class, 'customer_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', '.') . ' ₫';
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductItem::class, 'order_id');
    }
}
