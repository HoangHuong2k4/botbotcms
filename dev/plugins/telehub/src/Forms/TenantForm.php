<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Http\Requests\TenantRequest;
use Dev\Telehub\Models\Tenant;

class TenantForm extends FormAbstract
{
    public function setup(): void
    {
        $roles = \Dev\ACL\Models\Role::query()->pluck('name', 'id')->all();

        $this
            ->model(Tenant::class)
            ->setValidatorClass(TenantRequest::class);

        $tenant = $this->getModel();
        $userRoleId = $tenant->role_id;

        if (! $userRoleId && $tenant->user_id) {
            $tenant->loadMissing('user.roles');
            $userRoleId = $tenant->user?->roles->first()?->id;
        }

        $isSuperUser = \Illuminate\Support\Facades\Auth::user()?->isSuperUser();

        $this
            ->add('username', TextField::class, [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'readonly' => ! $isSuperUser,
                ],
            ])
            ->add('email', EmailField::class, [
                'label' => trans('core/base::forms.email'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.email_placeholder'),
                ],
            ]);

        if ($isSuperUser) {
            $this->add('role_id', SelectField::class, [
                'label' => trans('core/acl::users.role'),
                'choices' => ['' => trans('core/acl::users.select_role')] + $roles,
                'value' => $userRoleId,
                'selected' => $userRoleId,
            ]);
        } else {
            // Keep the role hidden for validation but show as static text if needed.
            // For now, just pass it hidden.
            $this->add('role_id', 'hidden', [
                'value' => $userRoleId,
            ]);
        }

        $this->add('password', 'password', [
            'label' => trans('core/base::forms.password'),
            'required' => $this->getModel()->id ? false : true,
            'attr' => [
                'placeholder' => trans('core/base::forms.password_placeholder'),
            ],
            'help_block' => [
                'text' => $this->getModel()->id ? trans('core/base::forms.password_helper') : null,
            ],
        ]);

        if ($isSuperUser) {
            $this->add('status', SelectField::class, StatusFieldOption::make());
        } else {
            $this->add('status', 'hidden', [
                'value' => $tenant->status ?: \Dev\Base\Enums\BaseStatusEnum::PUBLISHED,
            ]);
        }

        $this->setBreakFieldPoint('status');
    }
}
