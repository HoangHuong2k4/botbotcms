<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Traits\HasTenant;
use Dev\Telehub\Models\Tenant;

class BankWebhook extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_bank_webhooks';

    protected $fillable = [
        'tenant_id',
        'tran_id_bank',
        'amount',
        'description',
        'raw_json',
    ];

    protected $casts = [
        'raw_json' => 'json',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', '.') . ' ₫';
    }
}
