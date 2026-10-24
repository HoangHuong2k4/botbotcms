@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="dealer-manager-app">
        <dealer-manager
            api-url="{{ route('telehub.dealers.api') }}"
            update-url-prefix="{{ route('telehub.dealers.index') }}"
            search-customers-url="{{ route('telehub.dealers.search_customers') }}"
            :is-admin="{{ $isAdmin ? 'true' : 'false' }}">
        </dealer-manager>
    </div>
@endsection

@push('footer')
    <script>
        window.dealerData = {
            isAdmin: {{ json_encode($isAdmin) }}
        };
    </script>
    <script src="{{ asset('vendor/core/plugins/telehub/js/dealers.js') }}?v={{ time() }}"></script>
@endpush
