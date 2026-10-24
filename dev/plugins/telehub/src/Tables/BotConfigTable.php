<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\BotConfig;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class BotConfigTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(BotConfig::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.bot-configs.create'))
            ->addActions([
                EditAction::make()->route('telehub.bot-configs.edit'),
                DeleteAction::make()->route('telehub.bot-configs.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('bot_token')->route('telehub.bot-configs.edit')->title(trans('plugins/telehub::telehub.bot_configs.bot_token')),
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
                DeleteBulkAction::make()->permission('telehub.bot-configs.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'bot_token',
                    'created_at',
                    'status',
                ])->with(['tenant']);
            });
    }
}
