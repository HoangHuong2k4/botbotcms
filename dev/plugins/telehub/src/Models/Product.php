<?php

namespace Dev\Telehub\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Models\ProductCombo;
use Dev\Telehub\Traits\HasTenant;

class Product extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_products';

    protected $fillable = [
        'tenant_id',
        'name',
        'name_en',
        'icon',
        'price',
        'duration_days',
        'warranty_unit',
        'price_usd',
        'description',
        'description_en',
        'status',
        'is_api_product',
        'api_provider_id',
        'api_product_id',
        'api_cost_price',
        'api_stock',
        'api_sold',
        'api_delivery_mode',
        'api_markup_percent',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'is_api_product' => 'boolean',
        'api_cost_price' => 'decimal:2',
        'api_stock' => 'integer',
        'api_sold' => 'integer',
        'api_markup_percent' => 'decimal:2',
        'name' => SafeContent::class,
        'name_en' => SafeContent::class,
        'icon' => SafeContent::class,
        'price_usd' => 'decimal:2',
        'description' => SafeContent::class,
        'description_en' => SafeContent::class,
    ];

    public function apiProvider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ApiProvider::class, 'api_provider_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductItem::class, 'product_id');
    }

    public function combos(): HasMany
    {
        return $this->hasMany(ProductCombo::class, 'product_id')->orderBy('min_quantity')->orderBy('sort_order');
    }

    public function activeCombos(): HasMany
    {
        return $this->combos()->where('is_active', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }
}
