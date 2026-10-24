<x-core::datagrid>
    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/contact::contact.tables.full_name') }}</x-slot:title>
        {{ $contact->name }}
    </x-core::datagrid.item>

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/contact::contact.tables.email') }}</x-slot:title>
        {{ Html::mailto($contact->email) }}
    </x-core::datagrid.item>

    @if ($contact->phone)
        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/contact::contact.tables.phone') }}</x-slot:title>
            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
        </x-core::datagrid.item>
    @endif

    @if ($contact->gender)
        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/contact::contact.form_gender') }}</x-slot:title>
            {{ $contact->gender == 'male' ? 'Ông' : 'Bà' }}
        </x-core::datagrid.item>
    @endif

    <x-core::datagrid.item>
        <x-slot:title>{{ trans('plugins/contact::contact.tables.time') }}</x-slot:title>
        {{ $contact->created_at->translatedFormat('d M Y H:i:s') }}
    </x-core::datagrid.item>

    @if ($contact->address)
        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/contact::contact.tables.address') }}</x-slot:title>
            {{ $contact->address }}
        </x-core::datagrid.item>
    @endif

    @if ($contact->custom_fields)
        <x-core::datagrid.item>
            <x-slot:title>{{ trans('Contact') }}</x-slot:title>

            @php
                $texts = [];
            @endphp

            @foreach (json_decode($contact->custom_fields, true) as $key => $value)
                @continue(blank($value))

                @php
                    if ($key === 'visitModelHouse') {
                        $texts[] = 'Tham quan nhà mẫu';
                    } elseif ($key === 'deepConsultation') {
                        $texts[] = 'Tư vấn chuyên sâu';
                    } else {
                        $texts[] = $key . ' : ' . $value;
                    }
                @endphp
            @endforeach

            {{ implode(', ', $texts) }}
        </x-core::datagrid.item>
    @endif

    @if ($contact->subject)
        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/contact::contact.tables.subject') }}</x-slot:title>
            {{ $contact->subject }}
        </x-core::datagrid.item>
    @endif
</x-core::datagrid>

<x-core::datagrid.item class="mt-3">
    <x-slot:title>{{ trans('plugins/contact::contact.tables.content') }}</x-slot:title>
    {{ $contact->content ?: '...' }}
</x-core::datagrid.item>
