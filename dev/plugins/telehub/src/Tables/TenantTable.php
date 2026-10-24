<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\Tenant;
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
use Dev\Table\Columns\EmailColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class TenantTable extends TableAbstract
{
    public function setup(): void
    {
        $this->model(Tenant::class);

        $isSuperUser = \Illuminate\Support\Facades\Auth::user()?->isSuperUser();

        if ($isSuperUser) {
            $this->addHeaderAction(CreateHeaderAction::make()->route('telehub.tenants.create'));
        }

        $this->addActions([
            EditAction::make()->route('telehub.tenants.edit'),
        ]);

        if ($isSuperUser) {
            $this->addAction(DeleteAction::make()->route('telehub.tenants.destroy'));
        }

        $this->addColumns([
            IdColumn::make(),
            NameColumn::make('username')->route('telehub.tenants.edit')->title(trans('core/base::forms.name')),
            EmailColumn::make(),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ]);

        $this->addBulkActions([
            DeleteBulkAction::make()->permission('telehub.tenants.destroy'),
        ]);

        $this->addBulkChanges([
            StatusBulkChange::make(),
            CreatedAtBulkChange::make(),
        ]);

        $this->addFilters([
            IdColumn::make(),
            NameColumn::make('username'),
            EmailColumn::make(),
            StatusColumn::make(),
            CreatedAtColumn::make(),
        ]);

        $this->queryUsing(function (Builder $query) {
            $query->select([
                'id',
                'username',
                'email',
                'created_at',
                'status',
            ]);
        });
    }
}
