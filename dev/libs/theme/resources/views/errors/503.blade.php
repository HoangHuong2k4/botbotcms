@extends('libs/theme::errors.master')

@section('title', trans('libs/theme::theme.errors.503_service_unavailable'))

@section('content')
    <div class="empty">
        <div class="empty-img">
            <img
                src="{{ asset('vendor/core/core/base/images/503.svg') }}"
                alt="503"
                height="128"
            >
        </div>
        <p class="empty-title">{{ trans('libs/theme::theme.errors.temporarily_down') }}</p>
        <p class="empty-subtitle text-secondary">{{ trans('libs/theme::theme.errors.maintenance_description') }}</p>
        <p class="empty-subtitle text-secondary">
            <i>{!! BaseHelper::clean(trans('libs/theme::theme.errors.maintenance_admin_note')) !!}</i></p>
        @if ($email = get_admin_email()->first())
            <p class="empty-subtitle text-secondary">{!! BaseHelper::clean(trans('libs/theme::theme.errors.need_help_contact', ['mail' => Html::mailto($email)])) !!}</p>
        @endif
    </div>
@endsection
