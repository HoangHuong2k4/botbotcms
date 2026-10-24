<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\DepositRequest;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\DepositRequestTable;
use Dev\Telehub\Forms\DepositRequestForm;
use Illuminate\Http\Request;

class DepositRequestController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.deposit_requests.name'), route('telehub.deposit-requests.index'));
    }

    public function index(DepositRequestTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.deposit_requests.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return DepositRequestForm::create()->renderForm();
    }

    public function store(Request $request)
    {
        $form = DepositRequestForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.deposit-requests.index'))
            ->setNextUrl(route('telehub.deposit-requests.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(DepositRequest $depositRequest)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return DepositRequestForm::createFromModel($depositRequest)->renderForm();
    }

    public function update(DepositRequest $depositRequest, Request $request)
    {
        DepositRequestForm::createFromModel($depositRequest)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.deposit-requests.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(DepositRequest $depositRequest)
    {
        return DeleteResourceAction::make($depositRequest);
    }
}
