<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Http\Requests\TenantRequest;
use Dev\Telehub\Models\Tenant;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\TenantTable;
use Dev\Telehub\Forms\TenantForm;

class TenantController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.tenants.name'), route('telehub.tenants.index'));
    }

    public function index(TenantTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.tenants.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return TenantForm::create()->renderForm();
    }

    public function store(TenantRequest $request)
    {
        $form = TenantForm::create()->setRequest($request);

        $model = $form->getModel();
        $model->password = bcrypt($request->input('password'));
        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.tenants.index'))
            ->setNextUrl(route('telehub.tenants.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Tenant $tenant)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return TenantForm::createFromModel($tenant)->renderForm();
    }

    public function update(Tenant $tenant, TenantRequest $request)
    {
        $form = TenantForm::createFromModel($tenant)
            ->setRequest($request);

        $model = $form->getModel();
        if ($request->filled('password')) {
            $model->password = bcrypt($request->input('password'));
        } else {
            // Keep the old password
            $request->offsetUnset('password');
        }

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.tenants.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Tenant $tenant)
    {
        return DeleteResourceAction::make($tenant);
    }
}
