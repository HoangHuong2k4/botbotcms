<div class="mb-3 position-relative">
    <label
        for="enable_lazy_loading"
        class="form-label"
    >{{ trans('libs/shortcode::shortcode.form.enable_lazy_loading') }}</label>

    {!! Form::customSelect(
        'enable_lazy_loading',
        ['no' => trans('libs/shortcode::shortcode.form.no'), 'yes' => trans('libs/shortcode::shortcode.form.yes')],
        Arr::get($attributes, 'enable_lazy_loading', 'no'),
    ) !!}

    {!! Form::helper(trans('libs/shortcode::shortcode.form.lazy_loading_helper')) !!}
</div>
