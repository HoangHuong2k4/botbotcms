<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_order_details';

    protected $fillable = [
        'tenant_id',
        'order_id',
        'product_id',
        'quantity',
        'price',
        'price_usd',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'price_usd' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return number_format($this->price * $this->quantity, 0, ',', '.') . ' ₫';
    }
}
