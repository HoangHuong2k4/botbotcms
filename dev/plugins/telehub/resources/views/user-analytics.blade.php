@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<style>
    #user-analytics-app {
        --ua-font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --ua-mono: 'JetBrains Mono', monospace;
        --ua-bg: #0b0f19;
        --ua-card-bg: rgba(17, 24, 39, 0.85);
        --ua-card-border: rgba(255, 255, 255, 0.08);
        --ua-card-hover: rgba(255, 255, 255, 0.12);
        --ua-primary: #6366f1;
        --ua-primary-glow: rgba(99, 102, 241, 0.25);
        --ua-cyan: #06b6d4;
        --ua-emerald: #10b981;
        --ua-amber: #f59e0b;
        --ua-rose: #f43f5e;
        --ua-violet: #8b5cf6;
        --ua-text-main: #f3f4f6;
        --ua-text-muted: #9ca3af;
        --ua-text-sub: #6b7280;

        font-family: var(--ua-font);
        background: radial-gradient(circle at 10% 0%, rgba(99, 102, 241, 0.12) 0%, transparent 40%),
                    radial-gradient(circle at 90% 100%, rgba(6, 182, 212, 0.1) 0%, transparent 40%),
                    var(--ua-bg);
        color: var(--ua-text-main);
        padding: 24px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
    }

    #user-analytics-app * {
        box-sizing: border-box;
    }

    #user-analytics-app .ti {
        font-family: 'tabler-icons' !important;
        font-style: normal;
        line-height: 1;
        display: inline-block;
        vertical-align: middle;
    }

    /* Header */
    .ua-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--ua-card-border);
        margin-bottom: 24px;
    }

    .ua-title-wrap h1 {
        font-size: 26px;
        font-weight: 800;
        margin: 0;
        background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ua-title-wrap p {
        margin: 4px 0 0 0;
        color: var(--ua-text-muted);
        font-size: 13px;
    }

    .ua-controls {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .ua-btn-group {
        display: inline-flex;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--ua-card-border);
        border-radius: 12px;
        padding: 3px;
    }

    .ua-btn-group button {
        background: transparent;
        border: none;
        color: var(--ua-text-muted);
        padding: 7px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ua-btn-group button.active {
        background: var(--ua-primary);
        color: #fff;
        box-shadow: 0 4px 12px var(--ua-primary-glow);
    }

    .ua-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--ua-card-border);
        color: #fff;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 12px;
        outline: none;
        transition: border-color 0.2s;
    }
    .ua-input:focus {
        border-color: var(--ua-primary);
    }

    .ua-btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--ua-primary) 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.2s;
    }
    .ua-btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px var(--ua-primary-glow);
    }

    /* Metric Cards */
    .ua-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .ua-card {
        background: var(--ua-card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--ua-card-border);
        border-radius: 16px;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }
    .ua-card:hover {
        border-color: var(--ua-card-hover);
        transform: translateY(-2px);
    }

    .ua-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .ua-card-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ua-text-muted);
    }

    .ua-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .ua-card-val {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #fff;
        line-height: 1.2;
    }

    .ua-card-sub {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        margin-top: 6px;
        color: var(--ua-text-sub);
    }

    .ua-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        font-family: var(--ua-mono);
    }
    .ua-badge-green { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    .ua-badge-cyan  { background: rgba(6, 182, 212, 0.15);  color: #22d3ee; }
    .ua-badge-amber { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    .ua-badge-rose  { background: rgba(244, 63, 94, 0.15);  color: #fb7185; }
    .ua-badge-purple{ background: rgba(139, 92, 246, 0.15); color: #c084fc; }

    /* Section & Chart containers */
    .ua-charts-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(480px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .ua-panel {
        background: var(--ua-card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--ua-card-border);
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
    }

    .ua-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .ua-panel-title {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ua-panel-subtitle {
        font-size: 12px;
        color: var(--ua-text-muted);
        margin-top: 2px;
    }

    .ua-chart-box {
        position: relative;
        flex: 1;
        min-height: 280px;
        width: 100%;
    }

    /* Heatmap */
    .ua-heatmap-grid {
        display: grid;
        grid-template-columns: 70px repeat(24, 1fr);
        gap: 3px;
        margin-top: 12px;
        overflow-x: auto;
    }

    .ua-hm-cell {
        aspect-ratio: 1;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        font-family: var(--ua-mono);
        color: transparent;
        cursor: pointer;
        transition: transform 0.15s, outline 0.15s;
    }
    .ua-hm-cell:hover {
        transform: scale(1.3);
        z-index: 10;
        color: #fff !important;
        font-weight: 700;
        outline: 2px solid #fff;
    }

    .ua-hm-header-row {
        font-size: 10px;
        color: var(--ua-text-sub);
        text-align: center;
        padding-bottom: 4px;
        font-family: var(--ua-mono);
    }

    /* Funnel */
    .ua-funnel {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 8px;
    }

    .ua-funnel-step {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ua-funnel-label {
        width: 160px;
        font-size: 12px;
        font-weight: 600;
        color: var(--ua-text-muted);
        text-align: right;
    }

    .ua-funnel-bar-wrap {
        flex: 1;
        background: rgba(255, 255, 255, 0.05);
        height: 32px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
    }

    .ua-funnel-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--ua-primary), var(--ua-cyan));
        border-radius: 8px;
        transition: width 0.6s ease;
    }

    .ua-funnel-val {
        position: absolute;
        left: 12px;
        font-size: 12px;
        font-weight: 700;
        font-family: var(--ua-mono);
        color: #fff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.8);
    }

    .ua-funnel-pct {
        width: 60px;
        font-size: 12px;
        font-weight: 700;
        font-family: var(--ua-mono);
        color: var(--ua-cyan);
    }

    /* Tabs */
    .ua-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid var(--ua-card-border);
        margin-bottom: 16px;
        padding-bottom: 10px;
        overflow-x: auto;
    }

    .ua-tab-btn {
        background: transparent;
        border: none;
        color: var(--ua-text-muted);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .ua-tab-btn.active {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-bottom: 2px solid var(--ua-primary);
    }

    /* Tables */
    .ua-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .ua-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .ua-table th {
        background: rgba(255, 255, 255, 0.03);
        color: var(--ua-text-muted);
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid var(--ua-card-border);
    }

    .ua-table td {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        color: var(--ua-text-main);
        vertical-align: middle;
    }

    .ua-table tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .ua-rank {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.06);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        font-family: var(--ua-mono);
    }
    .ua-rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); color: #000; }
    .ua-rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); color: #000; }
    .ua-rank-3 { background: linear-gradient(135deg, #b45309, #78350f); color: #fff; }

    .ua-user-cell {
        display: flex;
        flex-direction: column;
    }
    .ua-user-name {
        font-weight: 600;
        color: #fff;
    }
    .ua-user-sub {
        font-size: 11px;
        color: var(--ua-text-sub);
        font-family: var(--ua-mono);
    }

    .ua-mono-val {
        font-family: var(--ua-mono);
        font-weight: 600;
    }

    /* Skeleton / Loading */
    .ua-loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(11, 15, 25, 0.7);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        z-index: 50;
    }

    .ua-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255, 255, 255, 0.1);
        border-top-color: var(--ua-primary);
        border-radius: 50%;
        animation: ua-spin 0.8s linear infinite;
    }

    @keyframes ua-spin {
        to { transform: rotate(360deg); }
    }

    /* Table Toolbar (Search, Filter, Sort) */
    .ua-table-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
        padding: 12px 14px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--ua-card-border);
        border-radius: 12px;
    }
    .ua-toolbar-left {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 280px;
    }
    .ua-toolbar-right {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }
    .ua-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 220px;
        max-width: 360px;
    }
    .ua-search-wrap .ti-search {
        position: absolute;
        left: 12px;
        color: var(--ua-text-muted);
        pointer-events: none;
    }
    .ua-search-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--ua-card-border);
        border-radius: 8px;
        color: #fff;
        padding: 8px 32px 8px 34px;
        font-size: 13px;
        font-family: var(--ua-font);
        outline: none;
        transition: all 0.2s;
    }
    .ua-search-input:focus {
        border-color: var(--ua-primary);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 2px var(--ua-primary-glow);
    }
    .ua-search-clear {
        position: absolute;
        right: 8px;
        background: none;
        border: none;
        color: var(--ua-text-sub);
        font-size: 16px;
        cursor: pointer;
        padding: 2px 6px;
        line-height: 1;
        display: none;
    }
    .ua-search-clear:hover {
        color: #fff;
    }
    .ua-select-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--ua-card-border);
        border-radius: 8px;
        color: #fff;
        padding: 8px 12px;
        font-size: 12px;
        font-family: var(--ua-font);
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .ua-select-control:focus {
        border-color: var(--ua-primary);
    }
    .ua-select-control option {
        background: #111827;
        color: #fff;
    }

    /* Sortable TH */
    .ua-th-sortable {
        cursor: pointer;
        user-select: none;
        transition: color 0.15s, background 0.15s;
    }
    .ua-th-sortable:hover {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.06) !important;
    }
    .ua-th-sortable .ua-sort-icon {
        display: inline-block;
        margin-left: 4px;
        font-size: 12px;
        color: var(--ua-text-sub);
        vertical-align: middle;
    }
    .ua-th-sortable.active .ua-sort-icon {
        color: var(--ua-primary);
    }

    /* Pagination Bar */
    .ua-pagination-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 14px;
        padding: 12px 14px;
        border-top: 1px solid var(--ua-card-border);
        font-size: 12px;
        color: var(--ua-text-muted);
    }
    .ua-pagination-nav {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ua-pg-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--ua-card-border);
        color: var(--ua-text-main);
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }
    .ua-pg-btn:hover:not(:disabled) {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    .ua-pg-btn.active {
        background: var(--ua-primary);
        border-color: var(--ua-primary);
        color: #fff;
        box-shadow: 0 0 10px var(--ua-primary-glow);
    }
    .ua-pg-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }
    .ua-pg-ellipsis {
        padding: 0 4px;
        color: var(--ua-text-sub);
    }

    @media (max-width: 768px) {
        .ua-charts-grid-2 { grid-template-columns: 1fr; }
        .ua-header { flex-direction: column; align-items: flex-start; }
        .ua-table-toolbar { flex-direction: column; align-items: stretch; }
        .ua-toolbar-left, .ua-toolbar-right { width: 100%; }
        .ua-search-wrap { max-width: 100%; }
    }
</style>
@endpush

@section('content')
<div id="user-analytics-app" data-api-url="{{ route('telehub.user-analytics.api') }}" data-is-admin="{{ $isAdmin ? '1' : '0' }}">
    <!-- Header -->
    <div class="ua-header">
        <div class="ua-title-wrap">
            <h1><i class="ti ti-chart-dots" style="color: #6366f1;"></i> Thống Kê Người Dùng Bot</h1>
            <p>Hành vi người dùng Telegram, tỷ lệ hoạt động Tuần / Tháng, khung giờ mua hàng & phân tích chuyển đổi API</p>
        </div>

        <div class="ua-controls">
            <!-- Preset Buttons -->
            <div class="ua-btn-group">
                <button type="button" class="preset-btn" data-days="7">7 ngày</button>
                <button type="button" class="preset-btn active" data-days="30">30 ngày</button>
                <button type="button" class="preset-btn" data-days="this_month">Tháng này</button>
                <button type="button" class="preset-btn" data-days="all">Năm nay</button>
            </div>

            <!-- Date Pickers -->
            <input type="date" id="ua-date-from" class="ua-input">
            <span style="color: var(--ua-text-sub);">→</span>
            <input type="date" id="ua-date-to" class="ua-input">

            <!-- Tenant dropdown (if admin) -->
            @if($isAdmin && count($tenants) > 0)
            <select id="ua-tenant-select" class="ua-input">
                <option value="">-- Tất cả Tenant --</option>
                @foreach($tenants as $t)
                    <option value="{{ $t->id }}">{{ $t->username ?: $t->email }} (#{{ $t->id }})</option>
                @endforeach
            </select>
            @endif

            <button type="button" id="ua-btn-refresh" class="ua-btn-action">
                <i class="ti ti-refresh"></i> Tải lại
            </button>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="ua-cards-grid">
        <!-- Card 1: Users & Active WAU/MAU -->
        <div class="ua-card">
            <div class="ua-card-top">
                <span class="ua-card-label">Tổng Người Dùng Bot</span>
                <div class="ua-card-icon" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                    <i class="ti ti-users"></i>
                </div>
            </div>
            <div class="ua-card-val" id="val-total-users">--</div>
            <div class="ua-card-sub">
                <span class="ua-badge ua-badge-cyan" id="badge-active-7d">WAU: --%</span>
                <span class="ua-badge ua-badge-purple" id="badge-active-30d">MAU: --%</span>
            </div>
        </div>

        <!-- Card 2: DAU & Stickiness -->
        <div class="ua-card">
            <div class="ua-card-top">
                <span class="ua-card-label">Hoạt Động Hôm Nay (DAU)</span>
                <div class="ua-card-icon" style="background: rgba(6, 182, 212, 0.15); color: #22d3ee;">
                    <i class="ti ti-activity"></i>
                </div>
            </div>
            <div class="ua-card-val" id="val-active-today">--</div>
            <div class="ua-card-sub">
                <span>Chỉ số gắn kết (DAU/MAU):</span>
                <span class="ua-badge ua-badge-green" id="badge-stickiness">--%</span>
            </div>
        </div>

        <!-- Card 3: Period Buyers & Conversion -->
        <div class="ua-card">
            <div class="ua-card-top">
                <span class="ua-card-label">Khách Mua Hàng Trong Kỳ</span>
                <div class="ua-card-icon" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                    <i class="ti ti-shopping-cart"></i>
                </div>
            </div>
            <div class="ua-card-val" id="val-period-buyers">--</div>
            <div class="ua-card-sub">
                <span>Tỷ lệ chuyển đổi (Buyers/Active):</span>
                <span class="ua-badge ua-badge-green" id="badge-conversion">--%</span>
            </div>
        </div>

        <!-- Card 4: Repeat Rate & Orders -->
        <div class="ua-card">
            <div class="ua-card-top">
                <span class="ua-card-label">Tỷ Lệ Mua Lặp Lại</span>
                <div class="ua-card-icon" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                    <i class="ti ti-repeat"></i>
                </div>
            </div>
            <div class="ua-card-val" id="val-repeat-rate">--%</div>
            <div class="ua-card-sub">
                <span id="sub-repeat-buyers">-- khách mua ≥2 đơn</span>
                <span>• TB <b id="sub-orders-per-buyer" style="color: #fff;">--</b> đơn/khách</span>
            </div>
        </div>

        <!-- Card 5: Revenue & API Share -->
        <div class="ua-card">
            <div class="ua-card-top">
                <span class="ua-card-label">Doanh Thu Trong Kỳ</span>
                <div class="ua-card-icon" style="background: rgba(244, 63, 94, 0.15); color: #fb7185;">
                    <i class="ti ti-cash"></i>
                </div>
            </div>
            <div class="ua-card-val" id="val-period-revenue">--</div>
            <div class="ua-card-sub">
                <span>Mua qua API:</span>
                <span class="ua-badge ua-badge-purple" id="badge-api-share">--%</span>
                <span class="ua-mono-val" id="sub-api-revenue" style="color: #cbd5e1;">--</span>
            </div>
        </div>
    </div>

    <!-- Charts Row 1: Weekly/Monthly Trend + Hourly Distribution -->
    <div class="ua-charts-grid-2">
        <!-- Left: Activity Trend (% Hoạt động theo Tuần / Tháng) -->
        <div class="ua-panel">
            <div class="ua-panel-header">
                <div>
                    <div class="ua-panel-title">
                        <i class="ti ti-chart-line" style="color: var(--ua-cyan);"></i>
                        Tỷ Lệ Người Hoạt Động & Khách Mua Hàng
                    </div>
                    <div class="ua-panel-subtitle">Theo dõi quy mô Active Users và Tỷ lệ chuyển đổi mua hàng</div>
                </div>
                <div class="ua-btn-group">
                    <button type="button" id="btn-view-weekly" class="active">Theo Tuần</button>
                    <button type="button" id="btn-view-monthly">Theo Tháng</button>
                </div>
            </div>
            <div class="ua-chart-box">
                <canvas id="chart-activity-trend"></canvas>
            </div>
        </div>

        <!-- Right: Hourly Distribution (Khung giờ mua hàng 0h-23h) -->
        <div class="ua-panel">
            <div class="ua-panel-header">
                <div>
                    <div class="ua-panel-title">
                        <i class="ti ti-clock" style="color: var(--ua-amber);"></i>
                        Khung Giờ Mua Hàng Cao Điểm (0h – 23h)
                    </div>
                    <div class="ua-panel-subtitle">Phân bố số lượng đơn hàng và doanh thu theo giờ trong ngày</div>
                </div>
                <span class="ua-badge ua-badge-amber" id="badge-peak-hour">Giờ vàng: --</span>
            </div>
            <div class="ua-chart-box">
                <canvas id="chart-hourly"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Day of Week + Funnel -->
    <div class="ua-charts-grid-2">
        <!-- Left: Day of Week -->
        <div class="ua-panel">
            <div class="ua-panel-header">
                <div>
                    <div class="ua-panel-title">
                        <i class="ti ti-calendar-event" style="color: var(--ua-emerald);"></i>
                        Tỷ Lệ Mua Theo Thứ Trong Tuần
                    </div>
                    <div class="ua-panel-subtitle">So sánh lưu lượng và doanh số từ Thứ 2 đến Chủ nhật</div>
                </div>
            </div>
            <div class="ua-chart-box">
                <canvas id="chart-weekday"></canvas>
            </div>
        </div>

        <!-- Right: Conversion Funnel -->
        <div class="ua-panel">
            <div class="ua-panel-header">
                <div>
                    <div class="ua-panel-title">
                        <i class="ti ti-filter" style="color: var(--ua-violet);"></i>
                        Phễu Chuyển Đổi Khách Hàng (Funnel)
                    </div>
                    <div class="ua-panel-subtitle">Từ tương tác Bot → Nạp tiền → Mua đơn đầu → Khách trung thành</div>
                </div>
            </div>
            <div class="ua-funnel" id="funnel-container">
                <!-- Rendered dynamically -->
            </div>
        </div>
    </div>

    <!-- Heatmap Row: Hour x Weekday Matrix -->
    <div class="ua-panel" style="margin-bottom: 24px;">
        <div class="ua-panel-header">
            <div>
                <div class="ua-panel-title">
                    <i class="ti ti-grid-dots" style="color: #ec4899;"></i>
                    Ma Trận Nhiệt Mua Hàng (Heatmap: Thứ × Khung Giờ)
                </div>
                <div class="ua-panel-subtitle">Điểm màu càng đậm thể hiện lượng đơn phát sinh càng nhiều tại khung giờ đó</div>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--ua-text-sub);">
                <span>Ít</span>
                <span style="display:inline-block; width:12px; height:12px; background:rgba(99,102,241,0.15); border-radius:2px;"></span>
                <span style="display:inline-block; width:12px; height:12px; background:rgba(99,102,241,0.4); border-radius:2px;"></span>
                <span style="display:inline-block; width:12px; height:12px; background:rgba(99,102,241,0.7); border-radius:2px;"></span>
                <span style="display:inline-block; width:12px; height:12px; background:#6366f1; border-radius:2px;"></span>
                <span>Nhiều</span>
            </div>
        </div>
        <div id="heatmap-container" style="overflow-x: auto;">
            <!-- Rendered dynamically -->
        </div>
    </div>

    <!-- Data Tables with Tabs -->
    <div class="ua-panel">
        <div class="ua-tabs">
            <button type="button" class="ua-tab-btn active" data-tab="tab-top-buyers">
                <i class="ti ti-trophy"></i> Top Khách Mua Nhiều Nhất
            </button>
            <button type="button" class="ua-tab-btn" data-tab="tab-top-api">
                <i class="ti ti-api"></i> Top Mua Bằng API
            </button>
            <button type="button" class="ua-tab-btn" data-tab="tab-products">
                <i class="ti ti-box"></i> Sản Phẩm Bán Chạy Nhất
            </button>
            <button type="button" class="ua-tab-btn" data-tab="tab-at-risk">
                <i class="ti ti-alert-triangle"></i> Khách Có Nguy Cơ Rời Bỏ
            </button>
            <button type="button" class="ua-tab-btn" data-tab="tab-segments">
                <i class="ti ti-pie"></i> Phân Khúc Đơn Hàng
            </button>
        </div>

        <!-- Tab 1: Top Buyers -->
        <div class="ua-tab-content" id="tab-top-buyers">
            <div class="ua-table-toolbar">
                <div class="ua-toolbar-left">
                    <div class="ua-search-wrap">
                        <i class="ti ti-search"></i>
                        <input type="text" id="ua-buyer-search" class="ua-search-input" placeholder="Tìm theo tên, @user, Telegram ID..." autocomplete="off">
                        <button type="button" id="ua-buyer-search-clear" class="ua-search-clear" title="Xóa tìm kiếm">&times;</button>
                    </div>
                    <select id="ua-buyer-role" class="ua-select-control" title="Lọc theo vai trò">
                        <option value="all">Tất cả vai trò</option>
                        <option value="dealer">Chỉ Đại Lý (CTV)</option>
                        <option value="retail">Chỉ Khách Lẻ</option>
                    </select>
                </div>
                <div class="ua-toolbar-right">
                    <select id="ua-buyer-sort" class="ua-select-control" title="Sắp xếp theo">
                        <option value="revenue_desc">Doanh thu: Cao → Thấp</option>
                        <option value="revenue_asc">Doanh thu: Thấp → Cao</option>
                        <option value="orders_desc">Số đơn: Nhiều → Ít</option>
                        <option value="orders_asc">Số đơn: Ít → Nhiều</option>
                        <option value="qty_desc">Tổng Acc: Nhiều → Ít</option>
                        <option value="name_asc">Tên: A → Z</option>
                        <option value="name_desc">Tên: Z → A</option>
                        <option value="balance_desc">Số dư ví: Cao → Thấp</option>
                        <option value="last_order_desc">Lần mua: Gần nhất</option>
                    </select>
                    <select id="ua-buyer-per-page" class="ua-select-control" title="Số dòng mỗi trang">
                        <option value="10">10 / trang</option>
                        <option value="15" selected>15 / trang</option>
                        <option value="25">25 / trang</option>
                        <option value="50">50 / trang</option>
                        <option value="100">100 / trang</option>
                    </select>
                </div>
            </div>

            <div class="ua-table-wrap">
                <table class="ua-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th class="ua-th-sortable" data-sort-key="name">Khách Hàng <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th>Telegram ID</th>
                            <th>Vai Trò</th>
                            <th class="ua-th-sortable" data-sort-key="balance">Số Dư Ví <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-sort-key="orders" style="text-align: right;">Số Đơn <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-sort-key="qty" style="text-align: right;">Tổng Acc <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-sort-key="revenue" style="text-align: right;">Doanh Thu (VND) <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th style="text-align: right;">Đơn Qua API</th>
                            <th class="ua-th-sortable" data-sort-key="last_order">Lần Mua Cuối <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-top-buyers">
                        <tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="ua-pagination-bar" id="ua-buyer-pagination" style="display: none;">
                <div id="ua-buyer-pg-info">Hiển thị 0 - 0 trong 0 khách</div>
                <div class="ua-pagination-nav" id="ua-buyer-pg-nav"></div>
            </div>
        </div>

        <!-- Tab 2: Top API -->
        <div class="ua-tab-content" id="tab-top-api" style="display: none;">
            <div class="ua-table-toolbar">
                <div class="ua-toolbar-left">
                    <div class="ua-search-wrap">
                        <i class="ti ti-search"></i>
                        <input type="text" id="ua-api-search" class="ua-search-input" placeholder="Tìm theo tên, @user, Telegram ID..." autocomplete="off">
                        <button type="button" id="ua-api-search-clear" class="ua-search-clear" title="Xóa tìm kiếm">&times;</button>
                    </div>
                    <select id="ua-api-key-filter" class="ua-select-control" title="Lọc trạng thái API">
                        <option value="all">Tất cả đối tác</option>
                        <option value="has_key">Đã cấp API Key</option>
                        <option value="no_key">Chưa cấp Key</option>
                    </select>
                </div>
                <div class="ua-toolbar-right">
                    <select id="ua-api-sort" class="ua-select-control" title="Sắp xếp theo">
                        <option value="revenue_desc">Doanh thu API: Cao → Thấp</option>
                        <option value="revenue_asc">Doanh thu API: Thấp → Cao</option>
                        <option value="orders_desc">Số đơn API: Nhiều → Ít</option>
                        <option value="orders_asc">Số đơn API: Ít → Nhiều</option>
                        <option value="qty_desc">Số Acc mua: Nhiều → Ít</option>
                        <option value="name_asc">Tên: A → Z</option>
                        <option value="name_desc">Tên: Z → A</option>
                        <option value="active_days_desc">Số ngày active: Nhiều nhất</option>
                        <option value="balance_desc">Số dư ví: Cao → Thấp</option>
                        <option value="last_order_desc">Lần mua: Gần nhất</option>
                    </select>
                    <select id="ua-api-per-page" class="ua-select-control" title="Số dòng mỗi trang">
                        <option value="10">10 / trang</option>
                        <option value="15" selected>15 / trang</option>
                        <option value="25">25 / trang</option>
                        <option value="50">50 / trang</option>
                        <option value="100">100 / trang</option>
                    </select>
                </div>
            </div>

            <div class="ua-table-wrap">
                <table class="ua-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th class="ua-th-sortable" data-api-sort-key="name">Khách Hàng / Đối Tác <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th>Telegram ID</th>
                            <th>Trạng Thái API</th>
                            <th class="ua-th-sortable" data-api-sort-key="balance">Số Dư <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-api-sort-key="orders" style="text-align: right;">Số Đơn API <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-api-sort-key="qty" style="text-align: right;">Số Acc Mua <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-api-sort-key="revenue" style="text-align: right;">Doanh Thu API (VND) <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-api-sort-key="active_days" style="text-align: center;">Số Ngày Active <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                            <th class="ua-th-sortable" data-api-sort-key="last_order">Lần Mua Cuối <i class="ti ti-arrows-sort ua-sort-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-top-api">
                        <tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="ua-pagination-bar" id="ua-api-pagination" style="display: none;">
                <div id="ua-api-pg-info">Hiển thị 0 - 0 trong 0 khách</div>
                <div class="ua-pagination-nav" id="ua-api-pg-nav"></div>
            </div>
        </div>

        <!-- Tab 3: Top Products -->
        <div class="ua-tab-content" id="tab-products" style="display: none;">
            <div class="ua-table-wrap">
                <table class="ua-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Tên Sản Phẩm</th>
                            <th style="text-align: right;">Khách Mua</th>
                            <th style="text-align: right;">Số Đơn</th>
                            <th style="text-align: right;">Số Acc Đã Bán</th>
                            <th style="text-align: right;">Doanh Thu</th>
                            <th style="text-align: right;">Đơn Qua API</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-products">
                        <tr><td colspan="7" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 4: At Risk -->
        <div class="ua-tab-content" id="tab-at-risk" style="display: none;">
            <div class="ua-table-wrap">
                <table class="ua-table">
                    <thead>
                        <tr>
                            <th>Khách Hàng</th>
                            <th>Telegram ID</th>
                            <th>Số Dư Còn Lại</th>
                            <th style="text-align: right;">Đã Từng Mua</th>
                            <th style="text-align: right;">Tổng Chi Tiêu</th>
                            <th>Lần Mua Gần Nhất</th>
                            <th>Số Ngày Chưa Mua</th>
                            <th>Đề Xuất Chăm Sóc</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-at-risk">
                        <tr><td colspan="8" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 5: Segments -->
        <div class="ua-tab-content" id="tab-segments" style="display: none;">
            <div class="ua-table-wrap">
                <table class="ua-table">
                    <thead>
                        <tr>
                            <th>Nhóm Khách Hàng</th>
                            <th style="text-align: right;">Số Lượng Khách</th>
                            <th style="text-align: right;">Tổng Doanh Thu</th>
                            <th style="text-align: right;">Tỷ Trọng Doanh Thu</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-segments">
                        <tr><td colspan="4" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const appEl = document.getElementById('user-analytics-app');
    if (!appEl) return;

    const apiUrl = appEl.getAttribute('data-api-url');
    let charts = {};
    let globalData = null;
    let trendMode = 'weekly'; // 'weekly' or 'monthly'

    let buyerState = {
        page: 1,
        perPage: 15,
        search: '',
        role: 'all',
        sort: 'revenue',
        dir: 'desc',
        loading: false,
    };

    let apiState = {
        page: 1,
        perPage: 15,
        search: '',
        keyFilter: 'all',
        sort: 'revenue',
        dir: 'desc',
        loading: false,
    };

    const fmtNum = (n) => new Intl.NumberFormat('vi-VN').format(n || 0);
    const fmtMoney = (n) => fmtNum(Math.round(n || 0)) + 'đ';

    function initDates() {
        const to = new Date();
        const from = new Date();
        from.setDate(to.getDate() - 29);

        document.getElementById('ua-date-to').value = to.toISOString().split('T')[0];
        document.getElementById('ua-date-from').value = from.toISOString().split('T')[0];
    }

    async function loadData() {
        const from = document.getElementById('ua-date-from').value;
        const to = document.getElementById('ua-date-to').value;
        const tenantSelect = document.getElementById('ua-tenant-select');
        const tenantId = tenantSelect ? tenantSelect.value : '';

        const btnRefresh = document.getElementById('ua-btn-refresh');
        btnRefresh.disabled = true;
        btnRefresh.innerHTML = '<i class="ti ti-loader ua-spin"></i> Đang tải...';

        try {
            const params = new URLSearchParams();
            if (from) params.set('date_from', from);
            if (to) params.set('date_to', to);
            if (tenantId) params.set('tenant_id', tenantId);

            params.set('buyer_page', buyerState.page);
            params.set('buyer_per_page', buyerState.perPage);
            if (buyerState.search) params.set('buyer_search', buyerState.search);
            if (buyerState.role !== 'all') params.set('buyer_role', buyerState.role);
            params.set('buyer_sort', buyerState.sort);
            params.set('buyer_dir', buyerState.dir);

            params.set('api_page', apiState.page);
            params.set('api_per_page', apiState.perPage);
            if (apiState.search) params.set('api_search', apiState.search);
            if (apiState.keyFilter !== 'all') params.set('api_key_filter', apiState.keyFilter);
            params.set('api_sort', apiState.sort);
            params.set('api_dir', apiState.dir);

            const res = await fetch(`${apiUrl}?${params.toString()}`);
            const json = await res.json();
            globalData = json.data;

            renderOverview(globalData.overview, globalData.current);
            renderActivityTrend(globalData);
            renderHourly(globalData.hourly);
            renderWeekday(globalData.weekday);
            renderFunnel(globalData.funnel);
            renderHeatmap(globalData.heatmap);
            renderTopBuyers(globalData.top_buyers, globalData.top_buyers_pagination);
            renderTopApi(globalData.top_api, globalData.top_api_pagination);
            renderTopProducts(globalData.top_products);
            renderAtRisk(globalData.at_risk);
            renderSegments(globalData.segments, globalData.current.revenue);
        } catch (e) {
            console.error('Error fetching analytics:', e);
            alert('Không thể tải dữ liệu thống kê. Vui lòng thử lại!');
        } finally {
            btnRefresh.disabled = false;
            btnRefresh.innerHTML = '<i class="ti ti-refresh"></i> Tải lại';
        }
    }

    function renderOverview(ov, cur) {
        document.getElementById('val-total-users').innerText = fmtNum(ov.total_users);
        document.getElementById('badge-active-7d').innerText = `WAU: ${ov.active_7d_pct}% (${fmtNum(ov.active_7d)})`;
        document.getElementById('badge-active-30d').innerText = `MAU: ${ov.active_30d_pct}% (${fmtNum(ov.active_30d)})`;

        document.getElementById('val-active-today').innerText = fmtNum(ov.active_today);
        document.getElementById('badge-stickiness').innerText = `${ov.stickiness}%`;

        document.getElementById('val-period-buyers').innerText = fmtNum(cur.buyers);
        document.getElementById('badge-conversion').innerText = `${cur.conversion}%`;

        document.getElementById('val-repeat-rate').innerText = `${cur.repeat_rate}%`;
        document.getElementById('sub-repeat-buyers').innerText = `${fmtNum(cur.repeat_buyers)} khách mua ≥2 đơn`;
        document.getElementById('sub-orders-per-buyer').innerText = `${cur.orders_per_buyer}`;

        document.getElementById('val-period-revenue').innerText = fmtMoney(cur.revenue);
        document.getElementById('badge-api-share').innerText = `API: ${cur.api_share}%`;
        document.getElementById('sub-api-revenue').innerText = fmtMoney(cur.api_revenue);
    }

    function renderActivityTrend(data) {
        const ctx = document.getElementById('chart-activity-trend').getContext('2d');
        if (charts.trend) charts.trend.destroy();

        const items = trendMode === 'weekly' ? data.weekly : data.monthly;
        const labels = items.map(i => i.label);
        const activePct = items.map(i => i.active_pct);
        const convPct = items.map(i => i.conversion);
        const activeCount = items.map(i => i.active);

        charts.trend = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '% Người Hoạt Động (Active %)',
                        data: activePct,
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'y'
                    },
                    {
                        label: '% Mua Hàng / Active (Conversion %)',
                        data: convPct,
                        borderColor: '#10b981',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.35,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Số Lượng Active (Users)',
                        data: activeCount,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.35,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { labels: { color: '#9ca3af', font: { family: 'Plus Jakarta Sans', size: 11 } } },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.dataset.yAxisID === 'y') return `${ctx.dataset.label}: ${ctx.parsed.y}%`;
                                return `${ctx.dataset.label}: ${fmtNum(ctx.parsed.y)} users`;
                            }
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: '#6b7280', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.04)' } },
                    y: {
                        position: 'left',
                        ticks: { color: '#06b6d4', callback: v => v + '%' },
                        grid: { color: 'rgba(255,255,255,0.04)' },
                        min: 0
                    },
                    y1: {
                        position: 'right',
                        ticks: { color: '#8b5cf6' },
                        grid: { drawOnChartArea: false },
                        min: 0
                    }
                }
            }
        });
    }

    function renderHourly(items) {
        const ctx = document.getElementById('chart-hourly').getContext('2d');
        if (charts.hourly) charts.hourly.destroy();

        const labels = items.map(i => i.label);
        const orders = items.map(i => i.orders);
        const apiOrders = items.map(i => i.api_orders);

        // Find peak hour
        let peak = items[0];
        items.forEach(it => { if (it.orders > (peak ? peak.orders : 0)) peak = it; });
        if (peak) {
            document.getElementById('badge-peak-hour').innerText = `Giờ cao điểm: ${peak.label} (${fmtNum(peak.orders)} đơn - ${peak.pct}%)`;
        }

        charts.hourly = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Đơn từ Telegram Bot',
                        data: orders.map((o, idx) => Math.max(0, o - apiOrders[idx])),
                        backgroundColor: '#6366f1',
                        borderRadius: 6,
                        stack: 'orders'
                    },
                    {
                        label: 'Đơn từ API',
                        data: apiOrders,
                        backgroundColor: '#ec4899',
                        borderRadius: 6,
                        stack: 'orders'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#9ca3af', font: { family: 'Plus Jakarta Sans', size: 11 } } },
                    tooltip: {
                        callbacks: {
                            afterBody: function(items) {
                                const idx = items[0].dataIndex;
                                const it = globalData.hourly[idx];
                                return `Doanh thu: ${fmtMoney(it.revenue)}\nTỷ trọng: ${it.pct}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: '#6b7280', font: { size: 9 } }, grid: { display: false } },
                    y: { ticks: { color: '#9ca3af' }, grid: { color: 'rgba(255,255,255,0.04)' } }
                }
            }
        });
    }

    function renderWeekday(items) {
        const ctx = document.getElementById('chart-weekday').getContext('2d');
        if (charts.weekday) charts.weekday.destroy();

        charts.weekday = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: items.map(i => i.label),
                datasets: [
                    {
                        label: 'Số Đơn Hàng',
                        data: items.map(i => i.orders),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderRadius: 8,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Doanh Thu (VND)',
                        data: items.map(i => i.revenue),
                        type: 'line',
                        borderColor: '#f59e0b',
                        borderWidth: 3,
                        pointBackgroundColor: '#f59e0b',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#9ca3af', font: { size: 11 } } }
                },
                scales: {
                    x: { ticks: { color: '#9ca3af' }, grid: { display: false } },
                    y: { position: 'left', ticks: { color: '#10b981' }, grid: { color: 'rgba(255,255,255,0.04)' } },
                    y1: { position: 'right', ticks: { color: '#f59e0b', callback: v => (v/1e6).toFixed(1) + 'M' }, grid: { display: false } }
                }
            }
        });
    }

    function renderFunnel(steps) {
        const container = document.getElementById('funnel-container');
        if (!container) return;
        const maxVal = Math.max(1, steps[0] ? steps[0].value : 1);

        let html = '';
        steps.forEach((step, idx) => {
            const pct = Math.round((step.value / maxVal) * 100);
            const prevVal = idx > 0 ? steps[idx - 1].value : step.value;
            const convFromPrev = prevVal > 0 ? Math.round((step.value / prevVal) * 100) : 0;

            html += `
            <div class="ua-funnel-step">
                <div class="ua-funnel-label">${step.label}</div>
                <div class="ua-funnel-bar-wrap">
                    <div class="ua-funnel-bar" style="width: ${pct}%;"></div>
                    <span class="ua-funnel-val">${fmtNum(step.value)}</span>
                </div>
                <div class="ua-funnel-pct">${idx === 0 ? '100%' : convFromPrev + '%'}</div>
            </div>`;
        });
        container.innerHTML = html;
    }

    function renderHeatmap(grid) {
        const container = document.getElementById('heatmap-container');
        if (!container) return;

        const dayNames = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'];
        let maxVal = 1;
        for (let d = 0; d < 7; d++) {
            for (let h = 0; h < 24; h++) {
                if (grid[d][h] > maxVal) maxVal = grid[d][h];
            }
        }

        let html = '<div class="ua-heatmap-grid">';
        html += '<div class="ua-hm-header-row"></div>';
        for (let h = 0; h < 24; h++) {
            html += `<div class="ua-hm-header-row">${h}h</div>`;
        }

        for (let d = 0; d < 7; d++) {
            html += `<div style="font-size:11px; color:#9ca3af; display:flex; align-items:center; font-weight:600;">${dayNames[d]}</div>`;
            for (let h = 0; h < 24; h++) {
                const count = grid[d][h];
                const alpha = count > 0 ? Math.max(0.12, (count / maxVal)).toFixed(2) : 0.03;
                const bg = count > 0 ? `rgba(99, 102, 241, ${alpha})` : 'rgba(255, 255, 255, 0.03)';
                html += `<div class="ua-hm-cell" style="background: ${bg};" title="${dayNames[d]} lúc ${h}:00 - ${count} đơn">${count > 0 ? count : ''}</div>`;
            }
        }
        html += '</div>';
        container.innerHTML = html;
    }

    function renderPagination(navEl, infoEl, barEl, p, onPageChange) {
        if (!barEl) return;
        if (!p || p.total === 0) {
            barEl.style.display = 'none';
            return;
        }
        barEl.style.display = 'flex';

        if (infoEl) {
            infoEl.innerHTML = `Hiển thị <b style="color:#fff;">${fmtNum(p.from)}</b> - <b style="color:#fff;">${fmtNum(p.to)}</b> trên tổng <b style="color:var(--ua-cyan);">${fmtNum(p.total)}</b>`;
        }

        if (!navEl) return;
        const cur = p.current_page;
        const last = p.last_page;

        let html = '';
        html += `<button type="button" class="ua-pg-btn" ${cur <= 1 ? 'disabled' : ''} data-page="${cur - 1}" title="Trang trước"><i class="ti ti-chevron-left"></i></button>`;

        const pages = [];
        for (let i = 1; i <= last; i++) {
            if (i === 1 || i === last || (i >= cur - 2 && i <= cur + 2)) {
                pages.push(i);
            }
        }

        let prev = 0;
        for (const page of pages) {
            if (prev > 0 && page - prev > 1) {
                html += `<span class="ua-pg-ellipsis">...</span>`;
            }
            html += `<button type="button" class="ua-pg-btn ${page === cur ? 'active' : ''}" data-page="${page}">${page}</button>`;
            prev = page;
        }

        html += `<button type="button" class="ua-pg-btn" ${cur >= last ? 'disabled' : ''} data-page="${cur + 1}" title="Trang sau"><i class="ti ti-chevron-right"></i></button>`;

        navEl.innerHTML = html;

        navEl.querySelectorAll('button[data-page]').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.disabled) return;
                const target = parseInt(this.getAttribute('data-page'), 10);
                if (target >= 1 && target <= last && target !== cur) {
                    onPageChange(target);
                }
            });
        });
    }

    async function fetchBuyersOnly() {
        buyerState.loading = true;
        const tbody = document.getElementById('tbody-top-buyers');
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);"><i class="ti ti-loader ua-spin"></i> Đang tải danh sách khách hàng...</td></tr>';

        const from = document.getElementById('ua-date-from').value;
        const to = document.getElementById('ua-date-to').value;
        const tenantSelect = document.getElementById('ua-tenant-select');
        const tenantId = tenantSelect ? tenantSelect.value : '';

        const params = new URLSearchParams();
        params.set('action', 'buyers');
        if (from) params.set('date_from', from);
        if (to) params.set('date_to', to);
        if (tenantId) params.set('tenant_id', tenantId);
        params.set('buyer_page', buyerState.page);
        params.set('buyer_per_page', buyerState.perPage);
        if (buyerState.search) params.set('buyer_search', buyerState.search);
        if (buyerState.role !== 'all') params.set('buyer_role', buyerState.role);
        params.set('buyer_sort', buyerState.sort);
        params.set('buyer_dir', buyerState.dir);

        try {
            const res = await fetch(`${apiUrl}?${params.toString()}`);
            const json = await res.json();
            renderTopBuyers(json.data, json.pagination);
        } catch(e) {
            console.error('Error fetching buyers:', e);
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:20px; color:#ef4444;">Không thể tải dữ liệu khách hàng. Vui lòng thử lại!</td></tr>';
        } finally {
            buyerState.loading = false;
        }
    }

    async function fetchApiBuyersOnly() {
        apiState.loading = true;
        const tbody = document.getElementById('tbody-top-api');
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);"><i class="ti ti-loader ua-spin"></i> Đang tải danh sách đối tác API...</td></tr>';

        const from = document.getElementById('ua-date-from').value;
        const to = document.getElementById('ua-date-to').value;
        const tenantSelect = document.getElementById('ua-tenant-select');
        const tenantId = tenantSelect ? tenantSelect.value : '';

        const params = new URLSearchParams();
        params.set('action', 'api_buyers');
        if (from) params.set('date_from', from);
        if (to) params.set('date_to', to);
        if (tenantId) params.set('tenant_id', tenantId);
        params.set('api_page', apiState.page);
        params.set('api_per_page', apiState.perPage);
        if (apiState.search) params.set('api_search', apiState.search);
        if (apiState.keyFilter !== 'all') params.set('api_key_filter', apiState.keyFilter);
        params.set('api_sort', apiState.sort);
        params.set('api_dir', apiState.dir);

        try {
            const res = await fetch(`${apiUrl}?${params.toString()}`);
            const json = await res.json();
            renderTopApi(json.data, json.pagination);
        } catch(e) {
            console.error('Error fetching api buyers:', e);
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:20px; color:#ef4444;">Không thể tải dữ liệu đối tác API. Vui lòng thử lại!</td></tr>';
        } finally {
            apiState.loading = false;
        }
    }

    function updateBuyerHeaderIcons() {
        document.querySelectorAll('#tab-top-buyers th.ua-th-sortable').forEach(th => {
            const key = th.getAttribute('data-sort-key');
            const icon = th.querySelector('.ua-sort-icon');
            if (!icon) return;
            if (key === buyerState.sort) {
                th.classList.add('active');
                icon.className = buyerState.dir === 'asc' ? 'ti ti-sort-ascending ua-sort-icon' : 'ti ti-sort-descending ua-sort-icon';
            } else {
                th.classList.remove('active');
                icon.className = 'ti ti-arrows-sort ua-sort-icon';
            }
        });
    }

    function updateApiHeaderIcons() {
        document.querySelectorAll('#tab-top-api th.ua-th-sortable').forEach(th => {
            const key = th.getAttribute('data-api-sort-key');
            const icon = th.querySelector('.ua-sort-icon');
            if (!icon) return;
            if (key === apiState.sort) {
                th.classList.add('active');
                icon.className = apiState.dir === 'asc' ? 'ti ti-sort-ascending ua-sort-icon' : 'ti ti-sort-descending ua-sort-icon';
            } else {
                th.classList.remove('active');
                icon.className = 'ti ti-arrows-sort ua-sort-icon';
            }
        });
    }

    function renderTopBuyers(buyers, pagination) {
        const tbody = document.getElementById('tbody-top-buyers');
        if (!buyers || buyers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Không tìm thấy khách hàng nào phù hợp với bộ lọc</td></tr>';
            renderPagination(document.getElementById('ua-buyer-pg-nav'), document.getElementById('ua-buyer-pg-info'), document.getElementById('ua-buyer-pagination'), pagination, () => {});
            return;
        }

        const startRank = (pagination && pagination.from) ? pagination.from : 1;

        tbody.innerHTML = buyers.map((b, idx) => {
            const currentRank = startRank + idx;
            const rankClass = currentRank === 1 ? 'ua-rank-1' : (currentRank === 2 ? 'ua-rank-2' : (currentRank === 3 ? 'ua-rank-3' : ''));
            const dealerBadge = b.is_dealer ? '<span class="ua-badge ua-badge-purple">CTV</span>' : '<span class="ua-badge ua-badge-cyan">Khách Lẻ</span>';
            const apiBadge = b.api_orders > 0 ? `<span class="ua-badge ua-badge-rose">${b.api_pct}% (${b.api_orders})</span>` : '<span style="color:#6b7280;">0</span>';

            return `
            <tr>
                <td><span class="ua-rank ${rankClass}">${currentRank}</span></td>
                <td>
                    <div class="ua-user-cell">
                        <span class="ua-user-name">${escapeHtml(b.name)}</span>
                        ${b.username ? `<span class="ua-user-sub">@${escapeHtml(b.username)}</span>` : ''}
                    </div>
                </td>
                <td class="ua-mono-val"><code>${b.telegram_id}</code></td>
                <td>${dealerBadge}</td>
                <td class="ua-mono-val" style="color: #34d399;">${fmtMoney(b.balance)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(b.orders)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(b.qty)}</td>
                <td style="text-align: right; color: #fbbf24; font-weight: 700;" class="ua-mono-val">${fmtMoney(b.revenue)}</td>
                <td style="text-align: right;">${apiBadge}</td>
                <td style="color: #9ca3af; font-size: 11px;">${b.last_order || '--'}</td>
            </tr>`;
        }).join('');

        renderPagination(
            document.getElementById('ua-buyer-pg-nav'),
            document.getElementById('ua-buyer-pg-info'),
            document.getElementById('ua-buyer-pagination'),
            pagination,
            (newPage) => {
                buyerState.page = newPage;
                fetchBuyersOnly();
            }
        );
        updateBuyerHeaderIcons();
    }

    function renderTopApi(users, pagination) {
        const tbody = document.getElementById('tbody-top-api');
        if (!users || users.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:var(--ua-text-sub);">Không tìm thấy đối tác API nào phù hợp với bộ lọc</td></tr>';
            renderPagination(document.getElementById('ua-api-pg-nav'), document.getElementById('ua-api-pg-info'), document.getElementById('ua-api-pagination'), pagination, () => {});
            return;
        }

        const startRank = (pagination && pagination.from) ? pagination.from : 1;

        tbody.innerHTML = users.map((u, idx) => {
            const currentRank = startRank + idx;
            const rankClass = currentRank === 1 ? 'ua-rank-1' : (currentRank === 2 ? 'ua-rank-2' : (currentRank === 3 ? 'ua-rank-3' : ''));
            const keyBadge = u.has_key ? '<span class="ua-badge ua-badge-green"><i class="ti ti-key"></i> Đã cấp Key</span>' : '<span class="ua-badge ua-badge-amber">Chưa Key</span>';

            return `
            <tr>
                <td><span class="ua-rank ${rankClass}">${currentRank}</span></td>
                <td>
                    <div class="ua-user-cell">
                        <span class="ua-user-name">${escapeHtml(u.name)}</span>
                        ${u.username ? `<span class="ua-user-sub">@${escapeHtml(u.username)}</span>` : ''}
                    </div>
                </td>
                <td class="ua-mono-val"><code>${u.telegram_id}</code></td>
                <td>${keyBadge}</td>
                <td class="ua-mono-val" style="color: #34d399;">${fmtMoney(u.balance)}</td>
                <td style="text-align: right;" class="ua-mono-val" style="color:#ec4899; font-weight:700;">${fmtNum(u.orders)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(u.qty)}</td>
                <td style="text-align: right; color: #fbbf24; font-weight: 700;" class="ua-mono-val">${fmtMoney(u.revenue)}</td>
                <td style="text-align: center;"><span class="ua-badge ua-badge-purple">${u.active_days} ngày</span></td>
                <td style="color: #9ca3af; font-size: 11px;">${u.last_order || '--'}</td>
            </tr>`;
        }).join('');

        renderPagination(
            document.getElementById('ua-api-pg-nav'),
            document.getElementById('ua-api-pg-info'),
            document.getElementById('ua-api-pagination'),
            pagination,
            (newPage) => {
                apiState.page = newPage;
                fetchApiBuyersOnly();
            }
        );
        updateApiHeaderIcons();
    }

    function renderTopProducts(products) {
        const tbody = document.getElementById('tbody-products');
        if (!products || products.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:20px; color:var(--ua-text-sub);">Không có dữ liệu sản phẩm</td></tr>';
            return;
        }

        tbody.innerHTML = products.map((p, idx) => `
            <tr>
                <td><span class="ua-rank">${idx + 1}</span></td>
                <td style="font-weight: 600; color: #fff;">${escapeHtml(p.name)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(p.buyers)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(p.orders)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(p.qty)}</td>
                <td style="text-align: right; color: #fbbf24; font-weight: 700;" class="ua-mono-val">${fmtMoney(p.revenue)}</td>
                <td style="text-align: right;"><span class="ua-badge ua-badge-rose">${fmtNum(p.api_orders)}</span></td>
            </tr>
        `).join('');
    }

    function renderAtRisk(list) {
        const tbody = document.getElementById('tbody-at-risk');
        if (!list || list.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:#34d399;">Tuyệt vời! Không có khách quen nào ngưng mua hàng trên 14 ngày.</td></tr>';
            return;
        }

        tbody.innerHTML = list.map(item => `
            <tr>
                <td>
                    <div class="ua-user-cell">
                        <span class="ua-user-name">${escapeHtml(item.name)}</span>
                        ${item.username ? `<span class="ua-user-sub">@${escapeHtml(item.username)}</span>` : ''}
                    </div>
                </td>
                <td class="ua-mono-val"><code>${item.telegram_id}</code></td>
                <td class="ua-mono-val" style="color: #34d399;">${fmtMoney(item.balance)}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(item.orders)} đơn</td>
                <td style="text-align: right; color: #fbbf24; font-weight: 700;" class="ua-mono-val">${fmtMoney(item.revenue)}</td>
                <td style="color: #9ca3af; font-size: 11px;">${item.last_order || '--'}</td>
                <td><span class="ua-badge ua-badge-rose">${item.days_since} ngày trước</span></td>
                <td>
                    <a href="https://t.me/${item.username ? item.username : ''}" target="_blank" class="ua-badge ua-badge-cyan" style="text-decoration:none;">
                        <i class="ti ti-brand-telegram"></i> Nhắn CSKH
                    </a>
                </td>
            </tr>
        `).join('');
    }

    function renderSegments(segments, totalRevenue) {
        const tbody = document.getElementById('tbody-segments');
        if (!segments || segments.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:20px; color:var(--ua-text-sub);">Không có dữ liệu phân khúc</td></tr>';
            return;
        }

        const totalRev = totalRevenue || 1;
        tbody.innerHTML = segments.map(seg => {
            const pct = ((seg.revenue / totalRev) * 100).toFixed(1);
            return `
            <tr>
                <td style="font-weight: 700; color: #fff;">${seg.label}</td>
                <td style="text-align: right;" class="ua-mono-val">${fmtNum(seg.customers)} khách</td>
                <td style="text-align: right; color: #fbbf24; font-weight: 700;" class="ua-mono-val">${fmtMoney(seg.revenue)}</td>
                <td style="text-align: right;"><span class="ua-badge ua-badge-purple">${pct}%</span></td>
            </tr>`;
        }).join('');
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Event listeners
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const p = this.getAttribute('data-days');
            const to = new Date();
            const from = new Date();

            if (p === '7') {
                from.setDate(to.getDate() - 6);
            } else if (p === '30') {
                from.setDate(to.getDate() - 29);
            } else if (p === 'this_month') {
                from.setDate(1);
            } else if (p === 'all') {
                from.setMonth(0, 1);
            }

            document.getElementById('ua-date-to').value = to.toISOString().split('T')[0];
            document.getElementById('ua-date-from').value = from.toISOString().split('T')[0];
            loadData();
        });
    });

    document.getElementById('ua-btn-refresh').addEventListener('click', loadData);
    const tenantSel = document.getElementById('ua-tenant-select');
    if (tenantSel) tenantSel.addEventListener('change', loadData);

    // Toggle Trend Weekly / Monthly
    document.getElementById('btn-view-weekly').addEventListener('click', function() {
        trendMode = 'weekly';
        this.classList.add('active');
        document.getElementById('btn-view-monthly').classList.remove('active');
        if (globalData) renderActivityTrend(globalData);
    });

    document.getElementById('btn-view-monthly').addEventListener('click', function() {
        trendMode = 'monthly';
        this.classList.add('active');
        document.getElementById('btn-view-weekly').classList.remove('active');
        if (globalData) renderActivityTrend(globalData);
    });

    // Tab Navigation
    document.querySelectorAll('.ua-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.ua-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.ua-tab-content').forEach(c => c.style.display = 'none');

            this.classList.add('active');
            const targetId = this.getAttribute('data-tab');
            const targetContent = document.getElementById(targetId);
            if (targetContent) targetContent.style.display = 'block';
        });
    });

    // Buyer Toolbar Events
    let buyerSearchTimeout = null;
    const buyerSearchInput = document.getElementById('ua-buyer-search');
    const buyerSearchClear = document.getElementById('ua-buyer-search-clear');
    if (buyerSearchInput) {
        buyerSearchInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (buyerSearchClear) buyerSearchClear.style.display = val ? 'block' : 'none';
            clearTimeout(buyerSearchTimeout);
            buyerSearchTimeout = setTimeout(() => {
                buyerState.search = val;
                buyerState.page = 1;
                fetchBuyersOnly();
            }, 350);
        });
    }
    if (buyerSearchClear) {
        buyerSearchClear.addEventListener('click', function() {
            if (buyerSearchInput) buyerSearchInput.value = '';
            this.style.display = 'none';
            buyerState.search = '';
            buyerState.page = 1;
            fetchBuyersOnly();
        });
    }

    const buyerRoleSelect = document.getElementById('ua-buyer-role');
    if (buyerRoleSelect) {
        buyerRoleSelect.addEventListener('change', function() {
            buyerState.role = this.value;
            buyerState.page = 1;
            fetchBuyersOnly();
        });
    }

    const buyerSortSelect = document.getElementById('ua-buyer-sort');
    if (buyerSortSelect) {
        buyerSortSelect.addEventListener('change', function() {
            const parts = this.value.split('_');
            buyerState.dir = parts.pop();
            buyerState.sort = parts.join('_');
            buyerState.page = 1;
            updateBuyerHeaderIcons();
            fetchBuyersOnly();
        });
    }

    const buyerPerPageSelect = document.getElementById('ua-buyer-per-page');
    if (buyerPerPageSelect) {
        buyerPerPageSelect.addEventListener('change', function() {
            buyerState.perPage = parseInt(this.value, 10) || 15;
            buyerState.page = 1;
            fetchBuyersOnly();
        });
    }

    document.querySelectorAll('#tab-top-buyers th.ua-th-sortable').forEach(th => {
        th.addEventListener('click', function() {
            const key = this.getAttribute('data-sort-key');
            if (buyerState.sort === key) {
                buyerState.dir = buyerState.dir === 'desc' ? 'asc' : 'desc';
            } else {
                buyerState.sort = key;
                buyerState.dir = 'desc';
            }
            buyerState.page = 1;
            if (buyerSortSelect) {
                const matchVal = `${buyerState.sort}_${buyerState.dir}`;
                if (buyerSortSelect.querySelector(`option[value="${matchVal}"]`)) {
                    buyerSortSelect.value = matchVal;
                }
            }
            updateBuyerHeaderIcons();
            fetchBuyersOnly();
        });
    });

    // API Toolbar Events
    let apiSearchTimeout = null;
    const apiSearchInput = document.getElementById('ua-api-search');
    const apiSearchClear = document.getElementById('ua-api-search-clear');
    if (apiSearchInput) {
        apiSearchInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (apiSearchClear) apiSearchClear.style.display = val ? 'block' : 'none';
            clearTimeout(apiSearchTimeout);
            apiSearchTimeout = setTimeout(() => {
                apiState.search = val;
                apiState.page = 1;
                fetchApiBuyersOnly();
            }, 350);
        });
    }
    if (apiSearchClear) {
        apiSearchClear.addEventListener('click', function() {
            if (apiSearchInput) apiSearchInput.value = '';
            this.style.display = 'none';
            apiState.search = '';
            apiState.page = 1;
            fetchApiBuyersOnly();
        });
    }

    const apiKeySelect = document.getElementById('ua-api-key-filter');
    if (apiKeySelect) {
        apiKeySelect.addEventListener('change', function() {
            apiState.keyFilter = this.value;
            apiState.page = 1;
            fetchApiBuyersOnly();
        });
    }

    const apiSortSelect = document.getElementById('ua-api-sort');
    if (apiSortSelect) {
        apiSortSelect.addEventListener('change', function() {
            const parts = this.value.split('_');
            apiState.dir = parts.pop();
            apiState.sort = parts.join('_');
            apiState.page = 1;
            updateApiHeaderIcons();
            fetchApiBuyersOnly();
        });
    }

    const apiPerPageSelect = document.getElementById('ua-api-per-page');
    if (apiPerPageSelect) {
        apiPerPageSelect.addEventListener('change', function() {
            apiState.perPage = parseInt(this.value, 10) || 15;
            apiState.page = 1;
            fetchApiBuyersOnly();
        });
    }

    document.querySelectorAll('#tab-top-api th.ua-th-sortable').forEach(th => {
        th.addEventListener('click', function() {
            const key = this.getAttribute('data-api-sort-key');
            if (apiState.sort === key) {
                apiState.dir = apiState.dir === 'desc' ? 'asc' : 'desc';
            } else {
                apiState.sort = key;
                apiState.dir = 'desc';
            }
            apiState.page = 1;
            if (apiSortSelect) {
                const matchVal = `${apiState.sort}_${apiState.dir}`;
                if (apiSortSelect.querySelector(`option[value="${matchVal}"]`)) {
                    apiSortSelect.value = matchVal;
                }
            }
            updateApiHeaderIcons();
            fetchApiBuyersOnly();
        });
    });

    // Start
    initDates();
    loadData();
})();
</script>
@endpush
