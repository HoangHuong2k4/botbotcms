<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\BotCustomer;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\BotCustomerTable;
use Dev\Telehub\Forms\BotCustomerForm;
use Dev\Telehub\Forms\TopupForm;
use Dev\Telehub\Models\BalanceLog;
use Dev\Telehub\Http\Requests\TopupRequest;
use Dev\Telehub\Tables\BalanceLogTable;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Facades\MetaBox;
use Illuminate\Http\Request;

class BotCustomerController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.bot_customers.name'), route('telehub.bot-customers.index'));
    }

    public function index(BotCustomerTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.bot_customers.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return BotCustomerForm::create()->renderForm();
    }

    public function store(\Dev\Telehub\Http\Requests\BotCustomerRequest $request)
    {
        $form = BotCustomerForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bot-customers.index'))
            ->setNextUrl(route('telehub.bot-customers.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(BotCustomer $botCustomer, BalanceLogTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        $this->breadcrumb()->add($botCustomer->full_name ?: $botCustomer->telegram_id);

        $table->setAjaxUrl(route('telehub.balance-logs.index', ['customer_id' => $botCustomer->id]))
            ->setView('core/table::base-table');

        /** @var FormAbstract $form */
        $form = BotCustomerForm::createFromModel($botCustomer);

        $form->addMetaBoxes([
            'transaction_history' => [
                'title' => trans('plugins/telehub::telehub.balance_logs.name'),
                'content' => view('plugins/telehub::bot-customers.history', compact('table'))->render(),
                'priority' => 'low',
            ],
        ]);

        return $form->renderForm();
    }

    public function update(BotCustomer $botCustomer, \Dev\Telehub\Http\Requests\BotCustomerRequest $request)
    {
        BotCustomerForm::createFromModel($botCustomer)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bot-customers.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(BotCustomer $botCustomer)
    {
        return DeleteResourceAction::make($botCustomer);
    }

    public function getTopup(BotCustomer $botCustomer)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.bot_customers.topup'));

        return TopupForm::createFromModel($botCustomer)->renderForm();
    }

    public function postTopup(BotCustomer $botCustomer, TopupRequest $request)
    {
        $amount = $request->input('amount');
        
        $botCustomer->increment('balance', $amount);

        BalanceLog::create([
            'customer_id' => $botCustomer->id,
            'tenant_id' => $botCustomer->tenant_id,
            'amount' => $amount,
            'type' => 'IN',
            'note' => $request->input('note') ?: 'Manual top-up from Admin',
        ]);

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bot-customers.index'))
            ->setMessage(trans('plugins/telehub::telehub.bot_customers.topup_success'));
    }

    public function cleanInactive(Request $request)
    {
        $days = (int) $request->input('days', 60);
        $cutoffDate = \Carbon\Carbon::now()->subDays($days);

        $query = BotCustomer::query()
            ->where('balance', '<=', 0)
            ->whereDoesntHave('orders')
            ->whereDoesntHave('depositRequests')
            ->where(function ($q) use ($cutoffDate) {
                $q->where('status', \Dev\Base\Enums\BaseStatusEnum::DRAFT)
                  ->orWhere(function ($sub) use ($cutoffDate) {
                      $sub->where(function ($dateQ) use ($cutoffDate) {
                          $dateQ->whereNull('created_at')
                                ->orWhere('created_at', '<=', $cutoffDate);
                      })
                      ->where(function ($updQ) use ($cutoffDate) {
                          $updQ->whereNull('updated_at')
                               ->orWhere('updated_at', '<=', $cutoffDate);
                      })
                      ->whereNotExists(function ($actQ) use ($cutoffDate) {
                          $actQ->select(\Illuminate\Support\Facades\DB::raw(1))
                               ->from('telehub_customer_activities')
                               ->whereColumn('telehub_customer_activities.customer_id', 'telehub_bot_customers.id')
                               ->where('telehub_customer_activities.last_seen_at', '>', $cutoffDate);
                      });
                  });
            });

        $count = 0;
        $query->chunkById(200, function ($customers) use (&$count) {
            $ids = $customers->pluck('id')->toArray();
            \Illuminate\Support\Facades\DB::table('telehub_customer_activities')->whereIn('customer_id', $ids)->delete();
            \Illuminate\Support\Facades\DB::table('telehub_dealer_prices')->whereIn('customer_id', $ids)->delete();
            $count += BotCustomer::whereIn('id', $ids)->delete();
        });

        return $this->httpResponse()
            ->setPreviousUrl(route('telehub.bot-customers.index'))
            ->setMessage("Đã dọn dẹp thành công {$count} người dùng không hoạt động (0 số dư, 0 đơn hàng, không vào bot > {$days} ngày)!");
    }
}
