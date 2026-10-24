<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\ProductCombo;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProductComboTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProductCombo::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.product-combos.create'))
            ->addActions([
                EditAction::make()->route('telehub.product-combos.edit'),
                DeleteAction::make()->route('telehub.product-combos.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('product_id')
                    ->title('Sản phẩm')
                    ->alignLeft()
                    ->getValueUsing(fn (FormattedColumn $col) => $col->getItem()->product?->name ?: 'N/A'),
                FormattedColumn::make('min_quantity')
                    ->title('SL tối thiểu')
                    ->alignCenter()
                    ->getValueUsing(fn (FormattedColumn $col) => '≥ ' . $col->getItem()->min_quantity),
                FormattedColumn::make('type')
                    ->title('Loại')
                    ->alignCenter()
                    ->getValueUsing(function (FormattedColumn $col) {
                        $item = $col->getItem();
                        return $item->type === 'bonus' ? '🎁 Tặng acc' : '🏷️ Giảm giá';
                    }),
                FormattedColumn::make('offer')
                    ->title('Ưu đãi')
                    ->alignLeft()
                    ->searchable(false)
                    ->orderable(false)
                    ->getValueUsing(function (FormattedColumn $col) {
                        $item = $col->getItem();
                        if ($item->type === 'bonus') {
                            return "<span class='badge bg-success'>Tặng {$item->bonus_qty} acc</span>";
                        }
                        if ($item->discount_percent > 0) {
                            return "<span class='badge bg-warning text-dark'>-{$item->discount_percent}%/acc</span>";
                        }
                        $fmt = number_format($item->discount_amount, 0, ',', '.');
                        return "<span class='badge bg-warning text-dark'>-{$fmt}đ/acc</span>";
                    }),
                FormattedColumn::make('label')
                    ->title('Nhãn')
                    ->alignLeft()
                    ->getValueUsing(fn (FormattedColumn $col) => $col->getItem()->label ?: '<i class="text-muted">—</i>'),
                FormattedColumn::make('is_active')
                    ->title('Trạng thái')
                    ->alignCenter()
                    ->getValueUsing(function (FormattedColumn $col) {
                        $item = $col->getItem();
                        return $item->is_active
                            ? "<span class='badge bg-success'>Bật</span>"
                            : "<span class='badge bg-secondary'>Tắt</span>";
                    }),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.product-combos.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->with('product')->orderBy('product_id')->orderBy('min_quantity');
            })
            ->onAjax(function (self $table) {
                return $table->toJson(
                    $table->table
                        ->eloquent($table->query())
                        ->filterColumn('offer', function ($query, $keyword) {
                            // Ignore search on virtual column
                        })
                );
            });
    }
}
