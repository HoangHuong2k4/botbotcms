<?php

namespace Dev\Member\Forms\Fronts\Auth;

use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\PasswordField;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\EmailFieldOption;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Dev\Member\Http\Requests\Fronts\Auth\ResetPasswordRequest;

class ResetPasswordForm extends AuthForm
{
    public static function formTitle(): string
    {
        return trans('plugins/member::member.form.reset_password_title');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('public.member.password.update'))
            ->icon('ti ti-lock')
            ->setValidatorClass(ResetPasswordRequest::class)
            ->heading(trans('plugins/member::dashboard.reset-password-title'))
            ->add(
                'token',
                'hidden',
                TextFieldOption::make()
                    ->value($this->request->route('token'))
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label(trans('plugins/member::dashboard.email_address'))
                    ->value($this->request->input('email'))
                    ->icon('ti ti-mail')
            )
            ->add(
                'password',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/member::dashboard.password'))
                    ->placeholder(trans('plugins/member::dashboard.password'))
                    ->icon('ti ti-lock')
            )
            ->add(
                'password_confirmation',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/member::dashboard.password-confirmation'))
                    ->placeholder(trans('plugins/member::dashboard.password-confirmation'))
                    ->icon('ti ti-lock')
            )
            ->submitButton(trans('plugins/member::dashboard.reset-password-cta'))
            ->add('back_to_login', HtmlField::class, [
                'html' => sprintf(
                    '<div class="mt-3 text-center"><a href="%s" class="text-decoration-underline">%s</a></div>',
                    route('public.member.login'),
                    trans('plugins/member::dashboard.back-to-login')
                ),
            ]);
    }
}
