<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\DepositRequest;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class DepositRequestTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(DepositRequest::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.deposit-requests.create'))
            ->addActions([
                EditAction::make()->route('telehub.deposit-requests.edit'),
                DeleteAction::make()->route('telehub.deposit-requests.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('amount')
                    ->title('Amount')
                    ->alignRight()
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->formatted_amount),
                NameColumn::make('payment_code')->title('Payment Code'),
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
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.deposit-requests.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'amount',
                    'payment_code',
                    'created_at',
                    'status',
                ])->with(['tenant']);
            });
    }
}
