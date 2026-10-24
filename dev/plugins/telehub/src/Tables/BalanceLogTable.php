<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\BalanceLog;
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

class BalanceLogTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(BalanceLog::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.balance-logs.create'))
            ->addActions([
                EditAction::make()->route('telehub.balance-logs.edit'),
                DeleteAction::make()->route('telehub.balance-logs.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('amount')
                    ->title('Amount')
                    ->alignRight()
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->formatted_amount),
                NameColumn::make('type')->title('Type'),
                NameColumn::make('note')->title('Note'),
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
                DeleteBulkAction::make()->permission('telehub.balance-logs.destroy'),
            ])
            ->addBulkChanges([
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'customer_id',
                    'amount',
                    'type',
                    'note',
                    'created_at',
                ])
                ->when(request()->input('customer_id'), function ($q, $customerId) {
                    return $q->where('customer_id', $customerId);
                })
                ->with(['tenant']);
            });
    }
}
