<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\BankWebhook;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class BankWebhookTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(BankWebhook::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.bank-webhooks.create'))
            ->addActions([
                EditAction::make()->route('telehub.bank-webhooks.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('tran_id_bank')->title('Bank Tran ID'),
                FormattedColumn::make('amount')
                    ->title('Amount')
                    ->alignRight()
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->formatted_amount),
                NameColumn::make('description')->title('Description'),
            ]);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->addColumn(\Dev\Table\Columns\LinkableColumn::make('tenant_id')
                ->title('Tenant')
                ->urlUsing(fn ($column) => route('telehub.tenants.edit', $column->getItem()->tenant_id))
                ->getValueUsing(fn ($column, $value) => $column->getItem()->tenant?->username ?: 'N/A')
                ->alignLeft());
        }

        $this
            ->addColumns([
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.bank-webhooks.destroy'),
            ])
            ->addBulkChanges([
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'tran_id_bank',
                    'amount',
                    'description',
                    'created_at',
                ])->with(['tenant']);
            });
    }
}
