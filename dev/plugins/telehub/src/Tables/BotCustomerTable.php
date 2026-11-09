<?php

namespace Dev\Telehub\Tables;

use Dev\Telehub\Models\BotCustomer;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\Actions\Action;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Dev\Table\HeaderActions\HeaderAction;
use Illuminate\Database\Eloquent\Builder;

class BotCustomerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(BotCustomer::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('telehub.bot-customers.create'))
            ->addHeaderAction(
                HeaderAction::make('clean_inactive')
                    ->label('Dọn user rác (>60 ngày)')
                    ->icon('ti ti-user-x')
                    ->color('danger')
                    ->url(route('telehub.bot-customers.clean-inactive', ['days' => 60]))
                    ->withDefaultAction(false)
            )
            ->addActions([
                EditAction::make()->route('telehub.bot-customers.edit'),
                Action::make('topup')
                    ->route('telehub.bot-customers.topup')
                    ->icon('ti ti-wallet')
                    ->label(trans('plugins/telehub::telehub.bot_customers.topup'))
                    ->color('info'),
                Action::make('toggle_ban')
                    ->renderUsing(function (Action $action) {
                        $item = $action->getItem();
                        $url = route('telehub.bot-customers.toggle-ban', $item->id);
                        if ($item->is_banned) {
                            return sprintf(
                                '<a href="%s" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-original-title="Bỏ chặn user này"><i class="ti ti-lock-open"></i></a>',
                                e($url)
                            );
                        }

                        return sprintf(
                            '<a href="%s" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-original-title="Chặn user khỏi Bot (Ban Scam)" onclick="return confirm(\'Bạn có chắc chắn muốn CHẶN người dùng này khỏi Bot không?\')"><i class="ti ti-ban"></i></a>',
                            e($url)
                        );
                    }),
                DeleteAction::make()->route('telehub.bot-customers.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('telegram_id')->route('telehub.bot-customers.edit')->title('Telegram ID'),
                FormattedColumn::make('username')
                    ->title('Username (@name)')
                    ->alignLeft()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $u = trim((string) ($column->getItem()->username ?? ''));
                        $u = ltrim($u, '@');
                        if ($u === '' || strtolower($u) === 'unknown') {
                            return '<span class="text-muted">—</span>';
                        }

                        return sprintf(
                            '<a href="https://t.me/%s" target="_blank" rel="noopener noreferrer" class="text-info fw-semibold">@%s</a>',
                            e($u),
                            e($u)
                        );
                    }),
                FormattedColumn::make('full_name')
                    ->title('Full Name')
                    ->alignLeft()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $item = $column->getItem();
                        $name = e($item->full_name ?: '—');
                        if ($item->is_banned) {
                            $name .= ' <span class="badge bg-danger text-white ms-1">🚫 Đã chặn</span>';
                        }

                        return $name;
                    }),
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
                FormattedColumn::make('balance')
                    ->title('Balance')
                    ->alignLeft()
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->formatted_balance),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('telehub.bot-customers.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->addFilters([
                IdColumn::make(),
                NameColumn::make('telegram_id')->title('Telegram ID'),
                NameColumn::make('username')->title('Username (@name)'),
                NameColumn::make('full_name')->title('Full Name'),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'tenant_id',
                    'telegram_id',
                    'username',
                    'full_name',
                    'balance',
                    'is_banned',
                    'created_at',
                    'status',
                ])->with(['tenant']);
            })
            ->onAjax(function (self $table) {
                return $table->toJson(
                    $table->table
                        ->eloquent($table->query())
                        ->filterColumn('username', function ($query, $keyword) {
                            $clean = ltrim(trim((string) $keyword), '@');
                            if ($clean !== '') {
                                $query->where('username', 'like', "%{$clean}%");
                            }
                        })
                );
            });
    }
}
