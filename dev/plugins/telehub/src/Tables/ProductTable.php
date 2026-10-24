<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\Product;
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
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProductTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Product::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.products.create'))
            ->addActions([
                EditAction::make()->route('telehub.products.edit'),
                DeleteAction::make()->route('telehub.products.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('telehub.products.edit'),
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
                FormattedColumn::make('price')
                    ->title('Price')
                    ->alignLeft()
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->formatted_price),
                FormattedColumn::make('duration_days')
                    ->title('Bảo hành')
                    ->alignCenter()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $item = $column->getItem();
                        if (empty($item->duration_days)) return 'Không BH';
                        $unit = $item->warranty_unit ?? 'day';
                        return $unit === 'hour'
                            ? $item->duration_days . 'H'
                            : ($item->duration_days == 1 ? '24h' : $item->duration_days . ' ngày');
                    }),
                FormattedColumn::make('stock')
                    ->title('Đã bán / Tổng (Còn lại)')
                    ->alignCenter()
                    ->searchable(false)
                    ->orderable(false)
                    ->getValueUsing(function (FormattedColumn $column) {
                        $product = $column->getItem();
                        $total = $product->items_count ?? 0;
                        $sold = $product->items_sold_count ?? 0;
                        $available = $total - $sold;
                        
                        $html = "<div class='text-center'>";
                        $html .= "<strong class='text-success'>{$sold}</strong> / <strong>{$total}</strong>";
                        $html .= "<div class='small text-muted'>Còn lại: {$available}</div>";
                        $html .= "</div>";
                        
                        return $html;
                    }),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.products.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->addFilters([
                IdColumn::make(),
                NameColumn::make(),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'name',
                    'icon',
                    'price',
                    'duration_days',
                    'created_at',
                    'status',
                ])->with(['tenant'])
                ->withCount('items')
                ->withCount(['items as items_sold_count' => function ($q) {
                    $q->where('is_sold', true);
                }]);
            })
            ->onAjax(function (self $table) {
                return $table->toJson(
                    $table->table
                        ->eloquent($table->query())
                        ->filterColumn('stock', function ($query, $keyword) {
                            // Ignore search on virtual column
                        })
                );
            });
    }
}
