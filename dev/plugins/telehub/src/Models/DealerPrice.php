<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerPrice extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_dealer_prices';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'product_id',
        'price',
        'price_usd',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_usd' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(BotCustomer::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
