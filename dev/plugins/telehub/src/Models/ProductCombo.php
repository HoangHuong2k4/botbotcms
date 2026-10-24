<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCombo extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_product_combos';

    protected $fillable = [
        'tenant_id',
        'product_id',
        'min_quantity',
        'type',
        'discount_percent',
        'discount_amount',
        'bonus_qty',
        'label',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'min_quantity'     => 'integer',
        'bonus_qty'        => 'integer',
        'sort_order'       => 'integer',
        'discount_percent' => 'float',
        'discount_amount'  => 'float',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Trả về mô tả ưu đãi dạng text để hiển thị trên UI/bot.
     */
    public function getDescriptionAttribute(): string
    {
        if ($this->type === 'bonus') {
            return "Mua ≥ {$this->min_quantity} → Tặng {$this->bonus_qty} acc";
        }

        if ($this->discount_percent > 0) {
            return "Mua ≥ {$this->min_quantity} → Giảm {$this->discount_percent}%/acc";
        }

        if ($this->discount_amount > 0) {
            $fmt = number_format($this->discount_amount, 0, ',', '.');
            return "Mua ≥ {$this->min_quantity} → Giảm {$fmt}đ/acc";
        }

        return "Mua ≥ {$this->min_quantity}";
    }
}
