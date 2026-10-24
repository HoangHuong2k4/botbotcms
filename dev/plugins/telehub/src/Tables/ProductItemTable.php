<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\ProductItem;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\NumberBulkChange;
use Dev\Table\BulkChanges\SelectBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\YesNoColumn;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProductItemTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProductItem::class)
            ->addHeaderActions([
                CreateHeaderAction::make()->route('telehub.product-items.create'),
                \Dev\Table\HeaderActions\HeaderAction::make('import')
                    ->label(trans('core/base::forms.import'))
                    ->icon('ti ti-file-import')
                    ->url(route('telehub.tools.data-synchronize.import.product-items.index'))
                    ->permission('telehub.product-items.create'),
            ])
            ->addActions([
                EditAction::make()->route('telehub.product-items.edit'),
                DeleteAction::make()->route('telehub.product-items.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('username')->title('Username')->alignLeft()->route('telehub.product-items.edit')->limit(30),
                FormattedColumn::make('password')->title('Password')->alignLeft()->limit(20),
                Column::make('note')->title('Note')->alignLeft(),
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
                YesNoColumn::make('is_sold')->title('Sold?'),
                FormattedColumn::make('customer_id')
                    ->title('Customer')
                    ->alignLeft()
                    ->getValueUsing(fn ($column) => $column->getItem()->customer?->full_name ?: 'N/A'),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.product-items.destroy'),
            ])
            ->addBulkChanges([
                CreatedAtBulkChange::make(),
            ])
            ->addFilters([
                NumberBulkChange::make()->name('id')->title('ID'),
                NameBulkChange::make()->name('username')->title('Username'),
                SelectBulkChange::make()
                    ->name('is_sold')
                    ->title('Sold?')
                    ->choices([
                        0 => trans('core/base::base.no'),
                        1 => trans('core/base::base.yes'),
                    ]),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'telehub_product_items.id',
                    'telehub_product_items.tenant_id',
                    'telehub_product_items.product_id',
                    'telehub_product_items.username',
                    'telehub_product_items.password',
                    'telehub_product_items.note',
                    'telehub_product_items.is_sold',
                    'telehub_product_items.customer_id',
                    'telehub_product_items.created_at',
                ])->with(['tenant', 'customer']);

                if (request()->has('product_id')) {
                    $query->where('telehub_product_items.product_id', request()->input('product_id'));
                }
            })
            ->onAjax(function (self $table) {
                return $table->toJson($table->table->eloquent($table->query()));
            });
    }
}
