@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')

@endpush

@section('content')
<div
    id="stat-vue-app"
    data-api-url="{{ route('telehub.statistics.api') }}"
    data-is-admin="{{ $isAdmin ? '1' : '0' }}"
    data-tenants="{{ json_encode($tenants->values()) }}"
    data-date-from="{{ $dateFrom }}"
    data-date-to="{{ $dateTo }}"
    data-month-year="{{ $monthYear }}"
    data-tenant-id="{{ $tenantId }}"
    data-statics-url="{{ route('telehub.statistics.index') }}"
>
    {{-- Loading placeholder shown before Vue mounts --}}
    <div class="d-flex justify-content-center align-items-center" style="height:300px;">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <div class="text-muted">Đang tải trang thống kê...</div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('vendor/core/plugins/telehub/js/statistics.js') }}"></script>
@endpush
