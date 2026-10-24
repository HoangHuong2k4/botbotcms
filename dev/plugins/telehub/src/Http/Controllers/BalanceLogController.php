<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\BalanceLog;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\BalanceLogTable;
use Dev\Telehub\Forms\BalanceLogForm;
use Illuminate\Http\Request;

class BalanceLogController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.balance_logs.name'), route('telehub.balance-logs.index'));
    }

    public function index(BalanceLogTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.balance_logs.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return BalanceLogForm::create()->renderForm();
    }

    public function store(Request $request)
    {
        $form = BalanceLogForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.balance-logs.index'))
            ->setNextUrl(route('telehub.balance-logs.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(BalanceLog $balanceLog)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return BalanceLogForm::createFromModel($balanceLog)->renderForm();
    }

    public function update(BalanceLog $balanceLog, Request $request)
    {
        BalanceLogForm::createFromModel($balanceLog)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.balance-logs.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(BalanceLog $balanceLog)
    {
        return DeleteResourceAction::make($balanceLog);
    }
}
