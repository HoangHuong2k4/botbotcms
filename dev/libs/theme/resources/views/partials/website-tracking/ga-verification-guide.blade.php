<div class="card">
    <div class="card-header">
        <strong>{{ trans('libs/theme::theme.settings.website_tracking.verification_title') }}</strong>
    </div>
    <div class="card-body">
        <ol class="mb-0">
            <li>
                <strong>{{ trans('libs/theme::theme.settings.website_tracking.verification.save_config') }}</strong>
                {{ trans('libs/theme::theme.settings.website_tracking.verification.click_save_button') }}
            </li>
            <li>
                <strong>{{ trans('libs/theme::theme.settings.website_tracking.verification.visit_website') }}</strong>
                {{ trans('libs/theme::theme.settings.website_tracking.verification.open_incognito') }}
            </li>
            <li>
                <strong>{{ trans('libs/theme::theme.settings.website_tracking.ga.check_realtime_report') }}</strong>
                {{ trans('libs/theme::theme.settings.website_tracking.ga.navigate_realtime') }}
            </li>
            <li>
                <strong>{{ trans('libs/theme::theme.settings.website_tracking.ga.wait_for_data') }}</strong>
                {{ trans('libs/theme::theme.settings.website_tracking.ga.see_visit_seconds') }}
            </li>
            <li>
                <strong>{{ trans('libs/theme::theme.settings.website_tracking.verification.check_console') }}</strong>
                {{ trans('libs/theme::theme.settings.website_tracking.ga.console_network_instructions') }}
            </li>
        </ol>
        <div class="alert alert-danger mt-3 mb-0 d-block">
            <p><strong>{{ trans('libs/theme::theme.settings.website_tracking.common_issues') }}</strong></p>
            <ul class="mb-0 mt-2">
                <li>
                    <strong>{{ trans('libs/theme::theme.settings.website_tracking.ga.issue_no_data') }}</strong>
                    {{ trans('libs/theme::theme.settings.website_tracking.ga.issue_no_data_solution') }}
                </li>
                <li>
                    <strong>{{ trans('libs/theme::theme.settings.website_tracking.ga.issue_wrong_format') }}</strong>
                    {{ trans('libs/theme::theme.settings.website_tracking.ga.issue_wrong_format_solution') }}
                </li>
                <li>
                    <strong>{{ trans('libs/theme::theme.settings.website_tracking.issue_ad_blocker') }}</strong>
                    {{ trans('libs/theme::theme.settings.website_tracking.issue_ad_blocker_solution') }}
                </li>
                <li>
                    <strong>{{ trans('libs/theme::theme.settings.website_tracking.ga.issue_multiple_ids') }}</strong>
                    {{ trans('libs/theme::theme.settings.website_tracking.ga.issue_multiple_ids_solution') }}
                </li>
            </ul>
        </div>
    </div>
</div>
