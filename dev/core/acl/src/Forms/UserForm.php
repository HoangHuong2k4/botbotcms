<?php

namespace Dev\ACL\Forms;

use Dev\ACL\Http\Requests\CreateUserRequest;
use Dev\ACL\Models\Role;
use Dev\ACL\Models\User;
use Dev\Base\Forms\FieldOptions\EmailFieldOption;
use Dev\Base\Forms\FieldOptions\PhoneNumberFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\PasswordField;
use Dev\Base\Forms\Fields\PhoneNumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;

class UserForm extends FormAbstract
{
    public function setup(): void
    {
        $roles = Role::query()->pluck('name', 'id');

        $defaultRole = $roles->where('is_default', 1)->first();

        $this
            ->model(User::class)
            ->setValidatorClass(CreateUserRequest::class)
            ->columns()
            ->add(
                'first_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.info.first_name'))
                    ->placeholder(trans('core/acl::users.first_name_placeholder'))
                    ->required()
                    ->maxLength(30)
            )
            ->add(
                'last_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.info.last_name'))
                    ->placeholder(trans('core/acl::users.last_name_placeholder'))
                    ->required()
                    ->maxLength(30)
            )
            ->add(
                'username',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.username'))
                    ->placeholder(trans('core/acl::users.username_placeholder'))
                    ->required()
                    ->maxLength(30)
            )
            ->add('email', TextField::class, EmailFieldOption::make()->required()->placeholder(trans('core/acl::users.email_placeholder')))
            ->add(
                'phone',
                PhoneNumberField::class,
                PhoneNumberFieldOption::make()
                    ->label(trans('core/acl::users.phone'))
                    ->placeholder(trans('core/acl::users.phone_placeholder'))
                    ->maxLength(20)
                    ->withCountryCodeSelection()
            )
            ->add(
                'password',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.password'))
                    ->placeholder(trans('core/acl::users.password_placeholder'))
                    ->required()
                    ->maxLength(60)
                    ->colspan(2)
            )
            ->add(
                'password_confirmation',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(trans('core/acl::users.password_confirmation'))
                    ->placeholder(trans('core/acl::users.password_confirmation_placeholder'))
                    ->required()
                    ->maxLength(60)
                    ->colspan(2)
            )
            ->add(
                'role_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('core/acl::users.role'))
                    ->choices(['' => trans('core/acl::users.select_role')] + $roles->all())
                    ->when($defaultRole, fn (SelectFieldOption $option) => $option->selected($defaultRole->id))
            )
            ->setBreakFieldPoint('role_id');
    }
}
