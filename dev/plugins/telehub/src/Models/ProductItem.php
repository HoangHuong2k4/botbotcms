<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Traits\HasTenant;

class ProductItem extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_product_items';

    protected static function booted(): void
    {
        static::saving(function (ProductItem $productItem) {
            if (empty($productItem->content)) {
                $content = $productItem->username;
                if ($productItem->password) {
                    $content .= ' | ' . $productItem->password;
                }
                if ($productItem->note) {
                    $content .= ' (' . $productItem->note . ')';
                }
                $productItem->content = $content;
            }
        });
    }

    protected $fillable = [
        'tenant_id',
        'product_id',
        'username',
        'password',
        'note',
        'content',
        'status',
        'is_sold',
        'customer_id',
        'order_id',
        'reserved_until',
        'reserved_by',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
        'reserved_until' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(BotCustomer::class, 'customer_id');
    }
}
