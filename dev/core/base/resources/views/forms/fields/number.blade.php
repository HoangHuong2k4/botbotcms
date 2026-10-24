<x-core::form.field
    :showLabel="$showLabel"
    :showField="$showField"
    :options="$options"
    :name="$name"
    :prepend="null"
    :append="null"
    :showError="$showError"
    :nameKey="$nameKey"
>
    <x-slot:label>
        @if ($showLabel && $options['label'] !== false && $options['label_show'])
            {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
        @endif
    </x-slot:label>

    @php
        $prepend = $options['prepend'] ?? null;
        $append = $options['append'] ?? null;
    @endphp

    @if ($prepend || $append)
        <div class="input-group">
            @if ($prepend)
                <span class="input-group-text">{!! $prepend !!}</span>
            @endif

            {!! Form::number($name, $options['value'], $options['attr']) !!}

            @if ($append)
                <span class="input-group-text">{!! $append !!}</span>
            @endif
        </div>
    @else
        {!! Form::number($name, $options['value'], $options['attr']) !!}
    @endif
</x-core::form.field>
