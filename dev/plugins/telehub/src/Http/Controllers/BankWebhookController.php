<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\BankWebhook;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\BankWebhookTable;
use Dev\Telehub\Forms\BankWebhookForm;
use Illuminate\Http\Request;

class BankWebhookController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.bank_webhooks.name'), route('telehub.bank-webhooks.index'));
    }

    public function index(BankWebhookTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.bank_webhooks.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return BankWebhookForm::create()->renderForm();
    }

    public function store(Request $request)
    {
        $form = BankWebhookForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bank-webhooks.index'))
            ->setNextUrl(route('telehub.bank-webhooks.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(BankWebhook $bankWebhook)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return BankWebhookForm::createFromModel($bankWebhook)->renderForm();
    }

    public function update(BankWebhook $bankWebhook, Request $request)
    {
        BankWebhookForm::createFromModel($bankWebhook)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bank-webhooks.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(BankWebhook $bankWebhook)
    {
        return DeleteResourceAction::make($bankWebhook);
    }
}
