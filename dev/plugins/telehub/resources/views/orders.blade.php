@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="telehub-orders-app">
        <order-filter 
            api-url="{{ route('telehub.orders.api') }}" 
            update-url-prefix="{{ route('telehub.orders.index') }}"
            init-payment-code="{{ $paymentCode ?? '' }}"
            :is-admin="{{ $isAdmin ? 'true' : 'false' }}">
        </order-filter>
    </div>
@endsection

@push('footer')
<script src="{{ asset('vendor/core/plugins/telehub/js/statistics.js') }}"></script>
@endpush
