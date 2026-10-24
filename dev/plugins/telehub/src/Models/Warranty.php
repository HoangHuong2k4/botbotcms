<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Traits\HasTenant;

class Warranty extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_warranties';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'order_id',
        'product_item_id',
        'type',
        'days_used',
        'refund_amount',
        'status',
        'note',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(BotCustomer::class, 'customer_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id');
    }
}
