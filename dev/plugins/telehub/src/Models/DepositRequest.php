<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Traits\HasTenant;

class DepositRequest extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_deposit_requests';

    protected $fillable = [
        'customer_id',
        'amount',
        'payment_code',
        'status',
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
