<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Traits\HasTenant;

class BalanceLog extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_balance_logs';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'type',
        'amount',
        'note',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(BotCustomer::class, 'customer_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', '.') . ' ₫';
    }
}
