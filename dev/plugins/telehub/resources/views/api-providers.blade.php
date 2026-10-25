@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<style>
    #api-providers-app {
        --ap-font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --ap-mono: 'JetBrains Mono', monospace;
        --ap-bg: #0b0f19;
        --ap-card-bg: rgba(17, 24, 39, 0.95);
        --ap-card-border: rgba(255, 255, 255, 0.1);
        --ap-card-hover: rgba(255, 255, 255, 0.18);
        --ap-primary: #6366f1;
        --ap-primary-glow: rgba(99, 102, 241, 0.35);
        --ap-cyan: #06b6d4;
        --ap-emerald: #10b981;
        --ap-amber: #f59e0b;
        --ap-rose: #f43f5e;
        --ap-violet: #8b5cf6;
        --ap-text-main: #f8fafc;
        --ap-text-muted: #cbd5e1;
        --ap-text-sub: #94a3b8;

        font-family: var(--ap-font);
        background: radial-gradient(circle at 10% 0%, rgba(99, 102, 241, 0.14) 0%, transparent 40%),
                    radial-gradient(circle at 90% 100%, rgba(6, 182, 212, 0.12) 0%, transparent 40%),
                    var(--ap-bg);
        color: #f8fafc !important;
        padding: 24px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.6);
    }

    #api-providers-app,
    #api-providers-app * {
        box-sizing: border-box;
    }

    #api-providers-app .ti {
        font-family: 'tabler-icons' !important;
        font-style: normal;
        line-height: 1;
        display: inline-block;
        vertical-align: middle;
    }

    /* Force Table text & background inside app against CMS overrides */
    #api-providers-app table,
    #api-providers-app .ap-table,
    .ap-modal table,
    .ap-modal .ap-table {
        color: #f8fafc !important;
        background: transparent !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
        margin: 0 !important;
    }

    #api-providers-app .ap-table th,
    .ap-modal .ap-table th {
        background: #0f172a !important;
        color: #94a3b8 !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 13px 14px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-top: none !important;
        white-space: nowrap !important;
        vertical-align: middle !important;
    }

    #api-providers-app .ap-table td,
    .ap-modal .ap-table td {
        background: transparent !important;
        color: #f1f5f9 !important;
        padding: 13px 14px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07) !important;
        border-top: none !important;
        vertical-align: middle !important;
        font-size: 13px !important;
    }

    #api-providers-app .ap-table tr:hover td,
    .ap-modal .ap-table tr:hover td {
        background: rgba(255, 255, 255, 0.035) !important;
    }

    #api-providers-app code,
    .ap-modal code {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #38bdf8 !important;
        padding: 2px 6px !important;
        border-radius: 4px !important;
        font-size: 11px !important;
        font-family: var(--ap-mono) !important;
    }

    /* Header */
    .ap-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--ap-card-border);
        margin-bottom: 24px;
    }

    .ap-title {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #ffffff 30%, #a5b4fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ap-subtitle {
        font-size: 13px;
        color: #94a3b8 !important;
        margin: 0;
        line-height: 1.5;
    }

    .ap-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 8px 15px !important;
        border-radius: 10px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        border: 1px solid transparent !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
        white-space: nowrap !important;
        line-height: 1.2 !important;
    }

    .ap-btn-primary {
        background: linear-gradient(135deg, var(--ap-primary), #4f46e5) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px var(--ap-primary-glow) !important;
    }
    .ap-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px var(--ap-primary-glow) !important;
        color: #ffffff !important;
    }

    .ap-btn-secondary {
        background: rgba(255, 255, 255, 0.07) !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #f1f5f9 !important;
    }
    .ap-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.14) !important;
        color: #ffffff !important;
    }

    .ap-btn-sm {
        padding: 6px 12px !important;
        font-size: 12px !important;
        border-radius: 8px !important;
    }

    .ap-btn-emerald {
        background: rgba(16, 185, 129, 0.16) !important;
        color: #34d399 !important;
        border-color: rgba(16, 185, 129, 0.35) !important;
    }
    .ap-btn-emerald:hover {
        background: rgba(16, 185, 129, 0.28) !important;
        color: #6ee7b7 !important;
    }

    .ap-btn-cyan {
        background: rgba(6, 182, 212, 0.16) !important;
        color: #22d3ee !important;
        border-color: rgba(6, 182, 212, 0.35) !important;
    }
    .ap-btn-cyan:hover {
        background: rgba(6, 182, 212, 0.28) !important;
        color: #67e8f9 !important;
    }

    .ap-btn-danger {
        background: rgba(244, 63, 94, 0.16) !important;
        color: #fb7185 !important;
        border-color: rgba(244, 63, 94, 0.35) !important;
    }
    .ap-btn-danger:hover {
        background: rgba(244, 63, 94, 0.28) !important;
        color: #fda4af !important;
    }

    .ap-btn-rose {
        background: rgba(244, 63, 94, 0.16) !important;
        color: #fb7185 !important;
        border-color: rgba(244, 63, 94, 0.35) !important;
    }
    .ap-btn-rose:hover {
        background: rgba(244, 63, 94, 0.28) !important;
        color: #fda4af !important;
    }

    .ap-btn-green {
        background: rgba(34, 197, 94, 0.16) !important;
        color: #4ade80 !important;
        border-color: rgba(34, 197, 94, 0.35) !important;
    }
    .ap-btn-green:hover {
        background: rgba(34, 197, 94, 0.28) !important;
        color: #86efac !important;
    }

    .ap-btn-amber {
        background: rgba(245, 158, 11, 0.16) !important;
        color: #fbbf24 !important;
        border-color: rgba(245, 158, 11, 0.35) !important;
    }
    .ap-btn-amber:hover {
        background: rgba(245, 158, 11, 0.28) !important;
        color: #fde68a !important;
    }

    .ap-status-btn {
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
        font-weight: 700 !important;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px !important;
        border-radius: 9999px;
        font-size: 11px !important;
        user-select: none;
    }
    .ap-status-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* KPI Cards */
    .ap-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .ap-card {
        background: var(--ap-card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--ap-card-border);
        border-radius: 16px;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }
    .ap-card:hover {
        border-color: var(--ap-card-hover);
        transform: translateY(-2px);
    }

    .ap-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .ap-card-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8 !important;
    }

    .ap-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .ap-card-val {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #ffffff !important;
        line-height: 1.2;
    }

    .ap-card-sub {
        font-size: 12px;
        margin-top: 6px;
        color: #94a3b8 !important;
    }

    /* Badges */
    .ap-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
        padding: 3px 9px !important;
        border-radius: 20px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        font-family: var(--ap-mono) !important;
        white-space: nowrap !important;
        line-height: 1.2 !important;
    }
    .ap-badge-green  { background: rgba(16, 185, 129, 0.18) !important; color: #34d399 !important; border: 1px solid rgba(16, 185, 129, 0.3) !important; }
    .ap-badge-cyan   { background: rgba(6, 182, 212, 0.18) !important;  color: #22d3ee !important; border: 1px solid rgba(6, 182, 212, 0.3) !important; }
    .ap-badge-amber  { background: rgba(245, 158, 11, 0.18) !important; color: #fbbf24 !important; border: 1px solid rgba(245, 158, 11, 0.3) !important; }
    .ap-badge-rose   { background: rgba(244, 63, 94, 0.18) !important;  color: #fb7185 !important; border: 1px solid rgba(244, 63, 94, 0.3) !important; }
    .ap-badge-purple { background: rgba(139, 92, 246, 0.18) !important; color: #c084fc !important; border: 1px solid rgba(139, 92, 246, 0.3) !important; }
    .ap-badge-muted  { background: rgba(255, 255, 255, 0.08) !important; color: #cbd5e1 !important; border: 1px solid rgba(255, 255, 255, 0.14) !important; }

    /* Pill ID for products */
    .ap-pill-id {
        display: inline-flex !important;
        align-items: center !important;
        font-size: 11px !important;
        font-family: var(--ap-mono) !important;
        color: #38bdf8 !important;
        background: rgba(56, 189, 248, 0.12) !important;
        border: 1px solid rgba(56, 189, 248, 0.25) !important;
        border-radius: 5px !important;
        padding: 1px 7px !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
    }

    /* Provider Tab Buttons */
    .ap-provider-tab-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 6px 14px !important;
        border-radius: 10px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #94a3b8 !important;
    }
    .ap-provider-tab-btn:hover {
        background: rgba(56, 189, 248, 0.12) !important;
        border-color: rgba(56, 189, 248, 0.35) !important;
        color: #ffffff !important;
    }
    .ap-provider-tab-btn.active {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.25), rgba(59, 130, 246, 0.25)) !important;
        border: 1px solid #38bdf8 !important;
        color: #38bdf8 !important;
        box-shadow: 0 0 12px rgba(56, 189, 248, 0.25) !important;
    }

    /* Panel Table */
    .ap-panel {
        background: var(--ap-card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--ap-card-border);
        border-radius: 18px;
        padding: 20px 22px;
        margin-bottom: 24px;
    }

    .ap-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ap-panel-title {
        font-size: 16px;
        font-weight: 700;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ap-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .ap-actions-wrap {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        flex-wrap: nowrap !important;
        white-space: nowrap !important;
        justify-content: flex-end !important;
    }

    .ap-btn-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid var(--ap-card-border) !important;
        color: #cbd5e1 !important;
        cursor: pointer;
        transition: all 0.2s;
    }
    .ap-btn-icon:hover {
        background: rgba(255, 255, 255, 0.18) !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
    }

    .ap-mono {
        font-family: var(--ap-mono) !important;
    }

    /* Live Catalog Toolbar */
    .ap-catalog-toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ap-markup-box {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1e293b !important;
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #334155;
    }
    .ap-markup-label {
        font-size: 12px;
        color: #94a3b8 !important;
        font-weight: 700;
        white-space: nowrap !important;
    }
    .ap-markup-input {
        width: 52px !important;
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        border-radius: 6px !important;
        color: #34d399 !important;
        font-weight: 800 !important;
        font-size: 13px !important;
        font-family: var(--ap-mono) !important;
        text-align: center !important;
        padding: 3px 4px !important;
        outline: none !important;
    }
    .ap-markup-unit {
        color: #34d399 !important;
        font-size: 12px;
        font-weight: 800;
    }

    .ap-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .ap-search-icon {
        position: absolute;
        left: 10px;
        color: #64748b !important;
        pointer-events: none;
        font-size: 14px;
    }
    .ap-search-input {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 10px !important;
        padding: 8px 12px 8px 32px !important;
        font-size: 12px !important;
        color: #ffffff !important;
        width: 200px !important;
        outline: none !important;
        transition: all 0.2s !important;
    }
    .ap-search-input::placeholder {
        color: #64748b !important;
    }
    .ap-search-input:focus {
        border-color: var(--ap-primary) !important;
        background: #0f172a !important;
        box-shadow: 0 0 0 2px var(--ap-primary-glow) !important;
    }

    .ap-filter-select {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 10px !important;
        padding: 8px 12px !important;
        font-size: 12px !important;
        color: #f8fafc !important;
        outline: none !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
    }
    .ap-filter-select option {
        background: #0f172a !important;
        color: #ffffff !important;
    }
    .ap-filter-select:focus {
        border-color: var(--ap-primary) !important;
        box-shadow: 0 0 0 2px var(--ap-primary-glow) !important;
    }

    /* Live Price Input in Tables */
    .live-price-input {
        background: #0f172a !important;
        color: #34d399 !important;
        border: 1.5px solid #059669 !important;
        border-radius: 8px !important;
        padding: 6px 10px !important;
        font-weight: 800 !important;
        font-size: 13px !important;
        font-family: var(--ap-mono) !important;
        text-align: right !important;
        width: 125px !important;
        outline: none !important;
        transition: all 0.2s !important;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.4) !important;
    }
    .live-price-input:focus {
        background: #022c22 !important;
        color: #6ee7b7 !important;
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3) !important;
    }

    /* Remove number spin buttons */
    .live-price-input::-webkit-outer-spin-button,
    .live-price-input::-webkit-inner-spin-button,
    .ap-markup-input::-webkit-outer-spin-button,
    .ap-markup-input::-webkit-inner-spin-button,
    .item-markup-pct::-webkit-outer-spin-button,
    .item-markup-pct::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .live-price-input[type=number],
    .ap-markup-input[type=number],
    .item-markup-pct[type=number] {
        -moz-appearance: textfield;
    }

    /* Margin & Markup Custom Styles */
    .ap-markup-cell {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        border-radius: 8px !important;
        padding: 4px 8px !important;
    }
    .item-markup-pct {
        width: 44px !important;
        background: transparent !important;
        border: none !important;
        color: #38bdf8 !important;
        font-weight: 800 !important;
        font-size: 13px !important;
        font-family: var(--ap-mono) !important;
        text-align: center !important;
        outline: none !important;
        padding: 0 !important;
    }
    .item-diff-badge {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #34d399 !important;
        font-family: var(--ap-mono) !important;
        white-space: nowrap !important;
    }
    .ap-stat-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        background: rgba(16, 185, 129, 0.12) !important;
        border: 1px solid rgba(16, 185, 129, 0.3) !important;
        border-radius: 10px !important;
        padding: 6px 14px !important;
    }
    .ap-pagination-btn {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #f1f5f9 !important;
        padding: 5px 10px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        cursor: pointer !important;
        transition: all 0.15s !important;
    }
    .ap-pagination-btn:hover {
        background: #334155 !important;
        color: #ffffff !important;
    }
    .ap-pagination-btn.active {
        background: var(--ap-primary) !important;
        border-color: var(--ap-primary) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    /* Emoji / Icon Editor Styling */
    .ap-emoji-wrap {
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        border-radius: 8px !important;
        padding: 3px 6px !important;
        position: relative !important;
        transition: border-color 0.15s ease;
    }
    .ap-emoji-wrap:focus-within {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 1px #38bdf8 !important;
    }
    .ap-emoji-preview {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 24px !important;
        height: 24px !important;
        background: rgba(255, 255, 255, 0.06) !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        flex-shrink: 0 !important;
    }
    .ap-emoji-input {
        width: 105px !important;
        background: transparent !important;
        border: none !important;
        color: #f1f5f9 !important;
        font-size: 12px !important;
        font-family: var(--ap-mono) !important;
        padding: 2px 4px !important;
        outline: none !important;
    }
    .ap-emoji-btn {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid #334155 !important;
        color: #94a3b8 !important;
        cursor: pointer !important;
        padding: 3px 5px !important;
        font-size: 13px !important;
        display: flex !important;
        align-items: center !important;
        border-radius: 6px !important;
        transition: all 0.15s ease !important;
    }
    .ap-emoji-btn:hover {
        color: #38bdf8 !important;
        border-color: #38bdf8 !important;
        background: rgba(56, 189, 248, 0.12) !important;
    }
    .ap-emoji-popover {
        position: fixed !important;
        z-index: 99999 !important;
        background: #0f172a !important;
        border: 1px solid #38bdf8 !important;
        border-radius: 12px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.75) !important;
        padding: 12px !important;
        display: none;
        width: 280px !important;
        white-space: normal !important;
    }
    .ap-emoji-chips-grid {
        display: grid !important;
        grid-template-columns: repeat(6, 1fr) !important;
        gap: 5px !important;
    }
    .ap-emoji-chip {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 32px !important;
        font-size: 17px !important;
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 6px !important;
        cursor: pointer !important;
        transition: all 0.12s ease !important;
    }
    .ap-emoji-chip:hover {
        background: #38bdf8 !important;
        border-color: #38bdf8 !important;
        transform: scale(1.15) !important;
    }

    /* Modal */
    .ap-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        padding: 20px;
    }

    .ap-modal {
        background: #111827 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 20px;
        width: 100%;
        max-width: 650px;
        box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.9);
        overflow: hidden;
        animation: apModalFade 0.2s ease-out;
    }

    .ap-modal-lg {
        max-width: 1100px;
    }

    @keyframes apModalFade {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .ap-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.02);
    }

    .ap-modal-title {
        font-size: 17px;
        font-weight: 700;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ap-modal-close {
        background: none;
        border: none;
        color: #94a3b8 !important;
        font-size: 22px;
        cursor: pointer;
        padding: 4px;
        line-height: 1;
        transition: color 0.15s;
    }
    .ap-modal-close:hover { color: #ffffff !important; }

    .ap-modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
        color: #f1f5f9 !important;
    }

    .ap-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding: 16px 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.02);
    }

    /* Form controls inside modal */
    .ap-form-group {
        margin-bottom: 16px;
    }
    .ap-form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #cbd5e1 !important;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .ap-form-input, .ap-form-select {
        width: 100%;
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        padding: 10px 14px;
        font-size: 13px;
        font-family: var(--ap-font);
        outline: none;
        transition: all 0.2s;
    }
    .ap-form-input::placeholder {
        color: #64748b !important;
    }
    .ap-form-input:focus, .ap-form-select:focus {
        border-color: var(--ap-primary) !important;
        background: #0f172a !important;
        box-shadow: 0 0 0 2px var(--ap-primary-glow) !important;
    }
    .ap-form-select option {
        background: #0f172a !important;
        color: #ffffff !important;
    }
    .ap-form-hint {
        font-size: 11px;
        color: #94a3b8 !important;
        margin-top: 4px;
    }
    .ap-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Spin */
    .ap-spin {
        animation: ap-spin 1s linear infinite;
    }
    @keyframes ap-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div id="api-providers-app" data-api-list="{{ route('telehub.api-providers.list') }}">
    <!-- Header -->
    <div class="ap-header">
        <div>
            <h1 class="ap-title">
                <i class="ti ti-plug-connected" style="color: var(--ap-primary);"></i>
                Đấu Nối API (Nhà Cung Cấp Kho Sỉ)
            </h1>
            <p class="ap-subtitle">
                Kết nối các kho sỉ bên ngoài, tự động lấy danh mục sản phẩm, đặt % lợi nhuận và bắn đơn hàng tự động từ Bot Telegram
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="ap-btn ap-btn-secondary" id="btn-refresh-all">
                <i class="ti ti-refresh"></i> Làm mới
            </button>
            <button type="button" class="ap-btn ap-btn-primary" id="btn-open-create">
                <i class="ti ti-plus"></i> Thêm Kết Nối API
            </button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="ap-cards-grid">
        <div class="ap-card">
            <div class="ap-card-top">
                <span class="ap-card-label">API Đang Kết Nối</span>
                <div class="ap-card-icon" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                    <i class="ti ti-server-2"></i>
                </div>
            </div>
            <div class="ap-card-val" id="kpi-total-providers">--</div>
            <div class="ap-card-sub" id="kpi-active-providers">-- đang hoạt động</div>
        </div>

        <div class="ap-card">
            <div class="ap-card-top">
                <span class="ap-card-label">Số Dư Kho Sỉ API</span>
                <div class="ap-card-icon" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                    <i class="ti ti-wallet"></i>
                </div>
            </div>
            <div class="ap-card-val" id="kpi-total-balance" style="color: #34d399;">--</div>
            <div class="ap-card-sub">Khả dụng để đặt hàng tự động</div>
        </div>

        <div class="ap-card">
            <div class="ap-card-top">
                <span class="ap-card-label">Sản Phẩm Đang Bán</span>
                <div class="ap-card-icon" style="background: rgba(6, 182, 212, 0.15); color: #22d3ee;">
                    <i class="ti ti-box"></i>
                </div>
            </div>
            <div class="ap-card-val" id="kpi-total-products">--</div>
            <div class="ap-card-sub">Đã nhập & đồng bộ giá lãi</div>
        </div>

        <div class="ap-card">
            <div class="ap-card-top">
                <span class="ap-card-label">Đơn Hàng Mua Qua API</span>
                <div class="ap-card-icon" style="background: rgba(244, 63, 94, 0.15); color: #fb7185;">
                    <i class="ti ti-shopping-cart-check"></i>
                </div>
            </div>
            <div class="ap-card-val" id="kpi-total-orders">--</div>
            <div class="ap-card-sub" id="kpi-total-revenue">Doanh thu: 0đ</div>
        </div>

        <div class="ap-card" style="border-color: rgba(16, 185, 129, 0.35); background: linear-gradient(145deg, rgba(17, 24, 39, 0.95), rgba(6, 78, 59, 0.3));">
            <div class="ap-card-top">
                <span class="ap-card-label" style="color: #34d399 !important;">🔥 Tổng Lợi Nhuận Full</span>
                <div class="ap-card-icon" style="background: rgba(16, 185, 129, 0.25); color: #34d399;">
                    <i class="ti ti-trending-up"></i>
                </div>
            </div>
            <div class="ap-card-val" id="kpi-total-profit" style="color: #34d399 !important;">0đ</div>
            <div class="ap-card-sub" id="kpi-profit-sub" style="color: #cbd5e1 !important;">Vốn: 0đ • Tỷ suất: +0%</div>
        </div>
    </div>

    <!-- Providers Table Panel -->
    <div class="ap-panel">
        <div class="ap-panel-header">
            <div class="ap-panel-title">
                <i class="ti ti-list-details" style="color: var(--ap-cyan);"></i>
                Danh Sách API Nhà Cung Cấp Đã Đấu Nối
            </div>
        </div>

        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">#</th>
                        <th style="min-width: 200px;">Nhà Cung Cấp</th>
                        <th style="min-width: 220px;">Base URL & Endpoint</th>
                        <th style="width: 120px; text-align: center;">Mã Đại Lý</th>
                        <th style="width: 160px; text-align: right;">Số Dư Ví Sỉ</th>
                        <th style="width: 120px; text-align: center;">SP Đã Nhập</th>
                        <th style="width: 130px; text-align: center;">Trạng Thái</th>
                        <th style="min-width: 290px; width: 290px; text-align: right;">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="tbody-providers">
                    <tr><td colspan="8" style="text-align: center; padding: 30px; color: var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải dữ liệu...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Live Catalog Panel (Hiển thị trực tiếp sản phẩm từ kho sỉ API) -->
    <div class="ap-panel" id="panel-live-catalog" style="margin-top: 24px;">
        <div class="ap-panel-header" style="border-bottom: 1px solid var(--ap-card-border); padding-bottom: 16px; margin-bottom: 16px; display: block;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 14px;">
                <div>
                    <div class="ap-panel-title" style="font-size: 18px; color: #ffffff !important;">
                        <i class="ti ti-packages" style="color: var(--ap-cyan);"></i>
                        <span id="live-catalog-provider-name">Kho Hàng Trực Tiếp Từ API (Live Catalog)</span>
                        <span class="ap-badge ap-badge-cyan" id="live-catalog-count-badge">0 SP</span>
                    </div>
                    <div style="font-size: 13px; color: #94a3b8 !important; margin-top: 5px;" id="live-catalog-sub">
                        Dữ liệu trực tiếp từ kho sỉ API • Bấm chọn nhà cung cấp bên dưới để chuyển kho hàng hoặc xem tất cả
                    </div>
                </div>

                <!-- Provider Selector Tabs -->
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">
                        <i class="ti ti-building-store"></i> Nhà Cung Cấp:
                    </span>
                    <div id="live-catalog-provider-tabs" style="display: inline-flex; gap: 8px; flex-wrap: wrap;">
                        <!-- Rendered dynamically via JS -->
                    </div>
                </div>
            </div>

            <!-- Filter & Tools Toolbar -->
            <div class="ap-catalog-toolbar" style="margin-top: 14px;">
                <div class="ap-markup-box" title="Thay đổi % lãi chung để tự động tính lại giá bán cho toàn bộ sản phẩm">
                    <span class="ap-markup-label">% Lãi chung:</span>
                    <input type="number" id="live-markup-pct" value="30" min="0" max="500" class="ap-markup-input">
                    <span class="ap-markup-unit">%</span>
                </div>

                <div style="display: flex; align-items: center; gap: 4px;">
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-quick-markup" data-pct="20">+20%</button>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-quick-markup" data-pct="30">+30%</button>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-quick-markup" data-pct="50">+50%</button>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-quick-markup" data-pct="100">+100%</button>
                </div>

                <div class="ap-search-wrap">
                    <i class="ti ti-search ap-search-icon"></i>
                    <input type="text" id="live-search" class="ap-search-input" placeholder="🔍 Tìm kiếm sản phẩm...">
                </div>

                <select id="live-filter-provider" class="ap-filter-select" style="font-weight: 700; border-color: rgba(56, 189, 248, 0.4); color: #38bdf8;">
                    <option value="all">🌐 Tất Cả Nhà Cung Cấp</option>
                </select>

                <select id="live-filter-stock" class="ap-filter-select">
                    <option value="all">📦 Tất cả sản phẩm</option>
                    <option value="available">✅ Còn hàng bên sỉ</option>
                    <option value="imported">🚀 Đã lưu trong shop</option>
                    <option value="published">🟢 Đang mở bán trên Bot</option>
                    <option value="draft">🟡 Đang tạm ẩn (Ngừng bán)</option>
                    <option value="not_imported">⏳ Chưa lưu (Chưa nhập)</option>
                </select>

                <button type="button" class="ap-btn ap-btn-emerald" id="btn-live-sync-catalog" title="Lấy giá sỉ mới nhất từ API và tự động tính lại giá bán theo % lãi đã lưu">
                    <i class="ti ti-refresh"></i> Đồng Bộ Giá Sỉ & Lãi
                </button>

                <button type="button" class="ap-btn ap-btn-primary" id="btn-live-bulk-import" title="Lưu cấu hình mức lãi chênh lệch và cập nhật giá bán cho các mục đã chọn">
                    <i class="ti ti-device-floppy"></i> Lưu / Bán Đã Chọn (<span id="live-selected-count">0</span>)
                </button>

                <button type="button" class="ap-btn ap-btn-green" id="btn-live-bulk-publish" title="Bật bán trên Bot Telegram cho các mục đã chọn">
                    <i class="ti ti-circle-check"></i> Bật Bán
                </button>

                <button type="button" class="ap-btn ap-btn-amber" id="btn-live-bulk-draft" title="Tạm ẩn (Ngừng bán trên Bot) cho các mục đã chọn">
                    <i class="ti ti-eye-off"></i> Tạm Ẩn
                </button>

                <button type="button" class="ap-btn ap-btn-rose" id="btn-live-bulk-unlink" title="Loại bỏ hoàn toàn các sản phẩm đã chọn ra khỏi shop (Hủy lưu, không còn liên kết bán)">
                    <i class="ti ti-trash"></i> Gỡ Khỏi Shop
                </button>
            </div>
        </div>

        <div class="ap-table-wrap">
            <table class="ap-table" id="table-live-catalog">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="live-check-all" style="cursor: pointer; transform: scale(1.15);">
                        </th>
                        <th style="min-width: 240px;">Sản Phẩm (Kho Sỉ)</th>
                        <th style="width: 140px; text-align: center;">Nhà Cung Cấp</th>
                        <th style="width: 165px; text-align: center;" title="Icon hoặc mã Telegram Custom Emoji ID dùng để hiển thị trên Bot">Icon / Emoji Bot</th>
                        <th style="width: 125px; text-align: center;">Hình Thức Trả</th>
                        <th style="width: 100px; text-align: center;">Tồn Kho Sỉ</th>
                        <th style="width: 130px; text-align: right;" title="Giá sỉ hiện tại bên API (có thể biến động)">Giá Gốc API (Tạm)</th>
                        <th style="min-width: 195px; text-align: center;" title="Cấu hình % lãi chênh lệch so với giá gốc, tự động nhảy tiền lãi tương ứng">Mức Lãi Chênh Lệch</th>
                        <th style="width: 165px; text-align: right;" title="Giá bán lẻ thực tế trên Bot shop = Giá gốc + Tiền lãi chênh lệch">Giá Bán Shop (Tự tính)</th>
                        <th style="width: 150px; text-align: center;">Trạng Thái Shop</th>
                        <th style="width: 160px; text-align: right;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody id="tbody-live-catalog">
                    <tr><td colspan="11" style="text-align:center; padding:30px; color:var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải danh sách hàng từ API...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- API Orders & Purchases Statistics Panel (Thống Kê Mua Hàng & Lợi Nhuận API) -->
    <div class="ap-panel" id="panel-api-orders" style="margin-top: 24px;">
        <div class="ap-panel-header" style="border-bottom: 1px solid var(--ap-card-border); padding-bottom: 16px; margin-bottom: 16px;">
            <div>
                <div class="ap-panel-title" style="font-size: 18px; color: #ffffff !important;">
                    <i class="ti ti-chart-arrows-vertical" style="color: var(--ap-emerald);"></i>
                    <span>Thống Kê Đơn Hàng Mua Qua API & Lợi Nhuận Thực Tế</span>
                    <span class="ap-badge ap-badge-green" id="orders-count-badge">0 Đơn</span>
                </div>
                <div style="font-size: 13px; color: #94a3b8 !important; margin-top: 5px;">
                    Chi tiết từng đơn khách mua trên Bot tự động khớp qua API • Tự động hạch toán Giá vốn, Doanh thu và Tiền lãi ròng
                </div>
            </div>

            <!-- Toolbar & Stats summary -->
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <div class="ap-stat-pill">
                    <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Lãi Full:</span>
                    <span style="font-size: 15px; font-weight: 800; color: #34d399;" class="ap-mono" id="orders-stat-profit">0đ</span>
                    <span class="ap-badge ap-badge-green" id="orders-stat-margin">+0%</span>
                </div>

                <div class="ap-search-wrap">
                    <i class="ti ti-search ap-search-icon"></i>
                    <input type="text" id="orders-search" class="ap-search-input" placeholder="🔍 Tìm mã đơn, Telegram ID..." style="width: 220px !important;">
                </div>

                <button type="button" class="ap-btn ap-btn-secondary" id="btn-refresh-orders">
                    <i class="ti ti-refresh"></i> Làm mới đơn
                </button>
            </div>
        </div>

        <div class="ap-table-wrap">
            <table class="ap-table" id="table-api-orders">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">#</th>
                        <th style="min-width: 170px;">Mã Đơn Shop & API</th>
                        <th style="min-width: 220px;">Sản Phẩm Mua Qua API</th>
                        <th style="min-width: 160px;">Khách Hàng (Telegram)</th>
                        <th style="width: 130px; text-align: right;">Tiền Vốn API</th>
                        <th style="width: 140px; text-align: right;">Khách Trả (Thu)</th>
                        <th style="width: 160px; text-align: right;">🔥 Tiền Lãi Thực Thu</th>
                        <th style="width: 130px; text-align: center;">Trạng Thái</th>
                        <th style="width: 150px; text-align: right;">Thời Gian</th>
                    </tr>
                </thead>
                <tbody id="tbody-api-orders">
                    <tr><td colspan="9" style="text-align: center; padding: 30px; color: var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải dữ liệu đơn hàng...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Orders Pagination -->
        <div id="orders-pagination" style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--ap-card-border);">
            <div style="font-size: 12px; color: #94a3b8;" id="orders-pagination-info">Hiển thị 0 đơn hàng</div>
            <div style="display: flex; gap: 6px;" id="orders-pagination-btns"></div>
        </div>
    </div>
</div>

<!-- Modal 1: Create / Edit Provider -->
<div class="ap-modal-backdrop" id="modal-provider">
    <div class="ap-modal">
        <div class="ap-modal-header">
            <div class="ap-modal-title" id="modal-provider-title">
                <i class="ti ti-plug"></i> Thêm Kết Nối API Mới
            </div>
            <button type="button" class="ap-modal-close" data-close-modal="modal-provider">&times;</button>
        </div>
        <form id="form-provider">
            <input type="hidden" id="provider-id" value="">
            <div class="ap-modal-body">
                <div class="ap-form-group" style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.25); border-radius: 12px; padding: 12px 14px; margin-bottom: 16px;">
                    <label class="ap-form-label" style="color: #a5b4fc; margin-bottom: 8px; font-weight: 700;">
                        <i class="ti ti-wand"></i> Chọn nhanh mẫu nhà cung cấp (Preset Provider)
                    </label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-cyan btn-apply-provider-preset" data-preset="canboso">
                            <i class="ti ti-brand-telegram"></i> Canboso (@Vincentrrrrr_Bot)
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-provider-preset" data-preset="minhais">
                            <i class="ti ti-robot"></i> MinhAIS (@minhais_8888_bot)
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-provider-preset" data-preset="haji">
                            <i class="ti ti-shopping-bag"></i> Haji Shop
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-provider-preset" data-preset="telestore">
                            <i class="ti ti-server"></i> TeleStore
                        </button>
                    </div>
                </div>

                <div class="ap-form-group">
                    <label class="ap-form-label">Tên nhà cung cấp / Tên Shop</label>
                    <input type="text" id="provider-name" class="ap-form-input" placeholder="Ví dụ: Haji Shop (@cataishop_bot)" required>
                </div>

                <div class="ap-form-group">
                    <label class="ap-form-label">Base URL API</label>
                    <input type="url" id="provider-base-url" class="ap-form-input ap-mono" placeholder="https://api.haji.in.net" required>
                    <div class="ap-form-hint">Địa chỉ gốc của máy chủ API (không kèm dấu / ở cuối)</div>
                </div>

                <div class="ap-grid-2">
                    <div class="ap-form-group">
                        <label class="ap-form-label">Kiểu xác thực (Auth Type)</label>
                        <select id="provider-auth-type" class="ap-form-select">
                            <option value="header">Header (X-API-Key)</option>
                            <option value="bearer">Bearer Token (Authorization)</option>
                        </select>
                    </div>
                    <div class="ap-form-group">
                        <label class="ap-form-label">Tên Header</label>
                        <input type="text" id="provider-header-name" class="ap-form-input ap-mono" value="X-API-Key" required>
                    </div>
                </div>

                <div class="ap-form-group">
                    <label class="ap-form-label">API Key</label>
                    <input type="text" id="provider-api-key" class="ap-form-input ap-mono" placeholder="dl_xxxxxxxxxxxxxxxxxxxxxx" required>
                    <div class="ap-form-hint">Khóa API được cấp từ đối tác. Tuyệt đối giữ bí mật!</div>
                </div>

                <div class="ap-grid-2">
                    <div class="ap-form-group">
                        <label class="ap-form-label">Mã Đại Lý (Partner ID, tùy chọn)</label>
                        <input type="text" id="provider-partner-id" class="ap-form-input ap-mono" placeholder="pt_b4c00fdb">
                    </div>
                    <div class="ap-form-group">
                        <label class="ap-form-label">Trạng thái</label>
                        <select id="provider-status" class="ap-form-select">
                            <option value="active">Hoạt động (Active)</option>
                            <option value="inactive">Tạm dừng (Inactive)</option>
                        </select>
                    </div>
                </div>

                <details style="margin-top: 10px; background: rgba(255,255,255,0.03); padding: 10px 14px; border-radius: 10px; border: 1px solid var(--ap-card-border);">
                    <summary style="font-size: 12px; font-weight: 600; cursor: pointer; color: var(--ap-cyan);">Cấu hình nâng cao các đường dẫn (Endpoints)</summary>
                    <div style="margin-top: 12px;">
                        <div class="ap-form-group">
                            <label class="ap-form-label">Endpoint lấy danh mục (Catalog)</label>
                            <input type="text" id="provider-ep-catalog" class="ap-form-input ap-mono" value="/api/v2/catalog">
                        </div>
                        <div class="ap-form-group">
                            <label class="ap-form-label">Endpoint đặt hàng (Orders)</label>
                            <input type="text" id="provider-ep-orders" class="ap-form-input ap-mono" value="/api/v2/orders">
                        </div>
                        <div class="ap-form-group">
                            <label class="ap-form-label">Endpoint kiểm tra số dư (Balance)</label>
                            <input type="text" id="provider-ep-balance" class="ap-form-input ap-mono" value="/api/v2/me">
                        </div>
                    </div>
                </details>
            </div>
            <div class="ap-modal-footer">
                <button type="button" class="ap-btn ap-btn-secondary" data-close-modal="modal-provider">Hủy</button>
                <button type="submit" class="ap-btn ap-btn-primary" id="btn-save-provider">
                    <i class="ti ti-check"></i> Lưu & Kiểm Tra Kết Nối
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Catalog & Import Products -->
<div class="ap-modal-backdrop" id="modal-catalog">
    <div class="ap-modal ap-modal-lg">
        <div class="ap-modal-header">
            <div>
                <div class="ap-modal-title" id="catalog-title">
                    <i class="ti ti-packages"></i> Kho Hàng Từ Đối Tác
                </div>
                <div style="font-size: 12px; color: var(--ap-text-muted);" id="catalog-sub">Đang kết nối kho hàng...</div>
            </div>
            <button type="button" class="ap-modal-close" data-close-modal="modal-catalog">&times;</button>
        </div>
        <div class="ap-modal-body">
            <!-- Toolbar inside catalog -->
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 16px; padding: 12px 16px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px;">
                <div style="display: flex; gap: 10px; flex: 1; min-width: 280px; align-items: center;">
                    <div style="position: relative; flex: 1;">
                        <input type="text" id="catalog-search" class="ap-form-input" placeholder="Tìm sản phẩm theo tên, ID..." style="padding-left: 34px;">
                        <i class="ti ti-search" style="position: absolute; left: 12px; top: 12px; color: #64748b;"></i>
                    </div>
                    <select id="catalog-filter-stock" class="ap-form-select" style="width: 180px;">
                        <option value="all">📦 Tất cả sản phẩm</option>
                        <option value="available">✅ Chỉ còn hàng</option>
                        <option value="not_imported">⏳ Chưa import</option>
                        <option value="imported">🚀 Đã import</option>
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 12px; color: #94a3b8; font-weight: 600;">% Lãi nhanh:</span>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-markup" data-pct="20">+20%</button>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-markup" data-pct="30">+30%</button>
                    <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-markup" data-pct="50">+50%</button>
                    <div style="display: flex; align-items: center; gap: 4px;">
                        <input type="number" id="custom-markup-pct" class="ap-form-input" style="width: 65px; padding: 6px 8px; font-size: 12px; text-align: center; font-weight: 700; color: #34d399;" placeholder="%" value="30">
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-cyan" id="btn-apply-custom-markup">Gán</button>
                    </div>
                </div>
            </div>

            <!-- Table products -->
            <div class="ap-table-wrap" style="max-height: 480px; overflow-y: auto;">
                <table class="ap-table">
                    <thead>
                        <tr>
                            <th style="width: 44px; text-align: center;"><input type="checkbox" id="check-all-catalog" style="cursor: pointer; transform: scale(1.15);"></th>
                            <th style="min-width: 240px;">Sản Phẩm Bên Đối Tác</th>
                            <th style="width: 155px; text-align: center;" title="Icon hoặc Telegram Custom Emoji ID dùng để hiển thị trên Bot">Icon / Emoji Bot</th>
                            <th style="width: 140px; text-align: center;">Loại Giao Hàng</th>
                            <th style="width: 120px; text-align: center;">Tồn Kho</th>
                            <th style="width: 130px; text-align: right;">Giá Sỉ Nhập</th>
                            <th style="width: 175px; text-align: right;">Giá Bán Shop (VNĐ)</th>
                            <th style="width: 170px; text-align: center;">Trạng Thái Trong Shop</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-catalog">
                        <tr><td colspan="8" style="text-align: center; padding: 30px; color: var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải danh sách hàng...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ap-modal-footer" style="justify-content: space-between;">
            <div id="catalog-selected-info" style="font-size: 13px; color: var(--ap-cyan); font-weight: 600;">
                Đã chọn 0 sản phẩm
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" class="ap-btn ap-btn-secondary" data-close-modal="modal-catalog">Đóng</button>
                <button type="button" class="ap-btn ap-btn-primary" id="btn-do-import">
                    <i class="ti ti-download"></i> Import Vào Shop & Mở Bán
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Global Emoji Picker Popover -->
<div id="global-emoji-popover" class="ap-emoji-popover">
    <div style="font-size: 11px; font-weight: 700; color: #38bdf8; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 6px; margin-bottom: 8px;">
        <span><i class="ti ti-mood-smile"></i> Chọn Emoji / Icon Bot</span>
        <button type="button" id="btn-close-global-emoji" style="background:none; border:none; color:#94a3b8; font-size:16px; cursor:pointer; line-height:1;">&times;</button>
    </div>
    <div style="font-size: 11px; color: #94a3b8; margin-bottom: 6px; font-weight: 600;">Emoji phổ biến:</div>
    <div class="ap-emoji-chips-grid" id="grid-preset-emojis"></div>
    <div style="font-size: 11px; color: #94a3b8; margin: 10px 0 6px 0; font-weight: 600;">Custom Emoji ID (Telegram):</div>
    <div style="display: flex; flex-direction: column; gap: 4px;">
        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-preset-id" data-val="5312361253610475399" style="font-size: 11px; justify-content: flex-start; padding: 4px 8px;">
            <i class="ti ti-sparkles" style="color: #38bdf8;"></i> Mặc định Bot (5312361253610475399)
        </button>
        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-preset-id" data-val="5445284980978621387" style="font-size: 11px; justify-content: flex-start; padding: 4px 8px;">
            <i class="ti ti-flame" style="color: #fb7185;"></i> Lửa Hot (5445284980978621387)
        </button>
        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-apply-preset-id" data-val="5240228673738527951" style="font-size: 11px; justify-content: flex-start; padding: 4px 8px;">
            <i class="ti ti-diamond" style="color: #34d399;"></i> Kim Cương VIP (5240228673738527951)
        </button>
    </div>
</div>
@endsection

@push('footer')
<script>
(function() {
    const appEl = document.getElementById('api-providers-app');
    if (!appEl) return;

    const baseUrl = '{{ route("telehub.api-providers.index") }}';
    const listUrl = '{{ route("telehub.api-providers.list") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    let providers = @json($providers ?? []);
    let initialCatalog = @json($initialCatalog ?? null);
    let activeCatalogProviderId = 'all';
    let catalogItems = initialCatalog ? (initialCatalog.products || []) : [];
    let apiStats = @json($apiStats ?? null);
    let ordersCurrentPage = 1;
    let ordersSearchQuery = '';

    const fmtNum = (n) => new Intl.NumberFormat('vi-VN').format(n || 0);
    const fmtMoney = (n) => fmtNum(Math.round(n || 0)) + 'đ';

    const commonEmojis = ['⚡', '🤖', '💎', '👑', '🔥', '⭐', '🎬', '🛍️', '🛒', '📦', '🛡️', '🎵', '🎁', '🔑', '💻', '🌐', '🚀', '💰', '🏆', '🎯', '💡', '📱', '🎮', '❤️'];

    function renderEmojiPreview(val) {
        if (!val) return '<span style="color:#64748b; font-size:10px;">Trống</span>';
        val = String(val).trim();
        if (/^\d+$/.test(val)) {
            return `<span class="ap-badge ap-badge-cyan" title="Custom Emoji ID: ${val}" style="font-size: 10px; padding: 2px 4px; line-height: 1;"><i class="ti ti-sparkles"></i> ID</span>`;
        }
        return `<span style="font-size: 16px; line-height: 1;">${escapeHtml(val)}</span>`;
    }

    let activeEmojiTargetInput = null;
    let activeEmojiPreviewTarget = null;

    function initGlobalEmojiPicker() {
        const grid = document.getElementById('grid-preset-emojis');
        if (grid) {
            grid.innerHTML = commonEmojis.map(em => `<div class="ap-emoji-chip" data-emoji="${em}">${em}</div>`).join('');
            grid.querySelectorAll('.ap-emoji-chip').forEach(chip => {
                chip.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const em = this.getAttribute('data-emoji');
                    applySelectedEmoji(em);
                });
            });
        }

        document.querySelectorAll('.btn-apply-preset-id').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const idVal = this.getAttribute('data-val');
                applySelectedEmoji(idVal);
            });
        });

        document.getElementById('btn-close-global-emoji')?.addEventListener('click', function(e) {
            e.stopPropagation();
            closeGlobalEmojiPicker();
        });

        document.addEventListener('click', function(e) {
            const popover = document.getElementById('global-emoji-popover');
            if (popover && popover.style.display === 'block') {
                if (!popover.contains(e.target) && !e.target.closest('.btn-open-emoji-popover') && !e.target.closest('.btn-open-modal-emoji-popover')) {
                    closeGlobalEmojiPicker();
                }
            }
        });
    }

    function openGlobalEmojiPicker(triggerBtn, prodId, isModal = false) {
        const popover = document.getElementById('global-emoji-popover');
        if (!popover) return;

        const inputSelector = isModal ? `.modal-item-icon-input[data-id="${prodId}"]` : `.item-icon-input[data-id="${prodId}"]`;
        const prevSelector = isModal ? `modal-emoji-prev-${prodId}` : `emoji-prev-${prodId}`;

        activeEmojiTargetInput = document.querySelector(inputSelector);
        activeEmojiPreviewTarget = document.getElementById(prevSelector);

        const rect = triggerBtn.getBoundingClientRect();
        popover.style.display = 'block';

        let top = rect.bottom + 8;
        let left = rect.left - 120;

        if (left < 10) left = 10;
        if (left + 290 > window.innerWidth) left = window.innerWidth - 300;
        if (top + 260 > window.innerHeight) {
            top = rect.top - 260;
        }

        popover.style.top = `${top}px`;
        popover.style.left = `${left}px`;
    }

    function closeGlobalEmojiPicker() {
        const popover = document.getElementById('global-emoji-popover');
        if (popover) popover.style.display = 'none';
        activeEmojiTargetInput = null;
        activeEmojiPreviewTarget = null;
    }

    function applySelectedEmoji(val) {
        if (activeEmojiTargetInput) {
            activeEmojiTargetInput.value = val;
            activeEmojiTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
        if (activeEmojiPreviewTarget) {
            activeEmojiPreviewTarget.innerHTML = renderEmojiPreview(val);
        }
        closeGlobalEmojiPicker();
    }

    async function loadProviders() {
        const tbody = document.getElementById('tbody-providers');
        if (!providers || providers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải dữ liệu...</td></tr>';
        }

        try {
            const res = await fetch(listUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error(`HTTP ${res.status}`);
            }
            const json = await res.json();
            providers = json.data || [];
            renderProviders();
            updateKpis();
            renderProviderTabs();

            if (!catalogItems.length && providers.length > 0) {
                loadLiveCatalog('all');
            }
        } catch (e) {
            console.error('Error fetching providers:', e);
            if (!providers || providers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:#ef4444;">Không thể tải danh sách kết nối API! (' + e.message + ')</td></tr>';
            }
        }
    }

    function updateKpis() {
        const total = providers.length;
        const active = providers.filter(p => p.status === 'active').length;
        const totalBal = providers.reduce((acc, p) => acc + parseFloat(p.balance || 0), 0);
        const totalProds = providers.reduce((acc, p) => acc + (p.products_count || 0), 0);
        const totalOrders = providers.reduce((acc, p) => acc + (p.orders_count || 0), 0);

        const elProv = document.getElementById('kpi-total-providers');
        if (elProv) elProv.innerText = total;
        const elAct = document.getElementById('kpi-active-providers');
        if (elAct) elAct.innerText = `${active}/${total} đang hoạt động`;
        const elBal = document.getElementById('kpi-total-balance');
        if (elBal) elBal.innerText = fmtMoney(totalBal);
        const elProds = document.getElementById('kpi-total-products');
        if (elProds) elProds.innerText = fmtNum(totalProds);

        if (apiStats) {
            const elOrd = document.getElementById('kpi-total-orders');
            if (elOrd) elOrd.innerText = fmtNum(apiStats.total_orders);
            const elRev = document.getElementById('kpi-total-revenue');
            if (elRev) elRev.innerText = `Doanh thu: ${fmtMoney(apiStats.total_revenue)}`;
            const elProf = document.getElementById('kpi-total-profit');
            if (elProf) elProf.innerText = fmtMoney(apiStats.total_profit);
            const elProfSub = document.getElementById('kpi-profit-sub');
            if (elProfSub) elProfSub.innerText = `Vốn: ${fmtMoney(apiStats.total_cost)} • Tỷ suất: +${apiStats.profit_margin_pct || 0}%`;

            const statProfit = document.getElementById('orders-stat-profit');
            if (statProfit) statProfit.innerText = fmtMoney(apiStats.total_profit);
            const statMargin = document.getElementById('orders-stat-margin');
            if (statMargin) statMargin.innerText = `+${apiStats.profit_margin_pct || 0}%`;
            const badgeOrd = document.getElementById('orders-count-badge');
            if (badgeOrd) badgeOrd.innerText = `${fmtNum(apiStats.total_orders)} Đơn`;
        } else {
            const elOrd = document.getElementById('kpi-total-orders');
            if (elOrd) elOrd.innerText = fmtNum(totalOrders);
        }
    }

    function renderProviders() {
        const tbody = document.getElementById('tbody-providers');
        if (!providers || providers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--ap-text-sub);">Chưa có kết nối API nào. Hãy bấm "Thêm Kết Nối API" để bắt đầu!</td></tr>';
            return;
        }

        tbody.innerHTML = providers.map((p, idx) => {
            const isAct = p.status === 'active';
            const statusBadge = isAct
                ? '<span class="ap-badge ap-badge-green"><i class="ti ti-circle-check"></i> Hoạt động</span>'
                : '<span class="ap-badge ap-badge-rose"><i class="ti ti-circle-x"></i> Tạm dừng</span>';

            return `
            <tr>
                <td class="ap-mono" style="text-align: center; color: #94a3b8 !important; font-weight: 600;">${idx + 1}</td>
                <td>
                    <div style="font-weight: 700; color: #ffffff !important; font-size: 13px;">${escapeHtml(p.name)}</div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 3px;">
                        Header: <code>${p.header_name}</code>
                    </div>
                </td>
                <td>
                    <div class="ap-mono" style="color: #38bdf8 !important; font-size: 12px; font-weight: 600;">${escapeHtml(p.base_url)}</div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 3px;">
                        Orders: <code>${p.endpoint_orders}</code>
                    </div>
                </td>
                <td style="text-align: center;">
                    <span class="ap-mono" style="color: #c7d2fe !important; background: rgba(165,180,252,0.14); padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">${p.partner_id ? escapeHtml(p.partner_id) : '--'}</span>
                </td>
                <td style="text-align: right; white-space: nowrap !important;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                        <span style="font-size: 14px; font-weight: 800; color: #34d399 !important;" class="ap-mono">
                            ${fmtMoney(p.balance)}
                        </span>
                        <button type="button" class="ap-btn-icon btn-check-balance" data-id="${p.id}" title="Kiểm tra lại số dư từ API">
                            <i class="ti ti-refresh"></i>
                        </button>
                    </div>
                </td>
                <td style="text-align: center;">
                    <span class="ap-badge ap-badge-purple" style="font-size: 11px;">
                        <i class="ti ti-box"></i> ${p.products_count || 0} SP
                    </span>
                </td>
                <td style="text-align: center;">
                    ${statusBadge}
                </td>
                <td style="text-align: right; white-space: nowrap !important;">
                    <div class="ap-actions-wrap">
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-cyan btn-open-catalog" data-id="${p.id}" title="Xem kho hàng & Import">
                            <i class="ti ti-packages"></i> Kho Sỉ
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-emerald btn-sync-catalog" data-id="${p.id}" title="Đồng bộ tồn kho & giá sỉ">
                            <i class="ti ti-refresh"></i> Đồng bộ
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-secondary btn-edit-provider" data-id="${p.id}" title="Chỉnh sửa cấu hình">
                            <i class="ti ti-edit"></i> Sửa
                        </button>
                        <button type="button" class="ap-btn ap-btn-sm ap-btn-danger btn-delete-provider" data-id="${p.id}" title="Xóa kết nối">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');

        bindTableEvents();
        renderProviderTabs();
    }

    function bindTableEvents() {
        // Check balance
        document.querySelectorAll('.btn-check-balance').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');
                const origHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Kiểm tra...';

                try {
                    const res = await fetch(`${baseUrl}/${id}/check-balance`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        alert(`✅ Số dư hiện tại bên đối tác: ${fmtMoney(data.balance)} ${data.currency || 'VND'}`);
                        loadProviders();
                    } else {
                        alert(`❌ Không thể kiểm tra số dư: ${data.error || 'Lỗi không xác định'}`);
                    }
                } catch(e) {
                    alert('Lỗi kết nối kiểm tra số dư!');
                } finally {
                    this.disabled = false;
                    this.innerHTML = origHtml;
                }
            });
        });

        // Open Catalog (cuộn xuống bảng Kho Hàng Sỉ Live)
        document.querySelectorAll('.btn-open-catalog').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                loadLiveCatalog(id);
                const panel = document.getElementById('panel-live-catalog');
                if (panel) {
                    panel.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Sync catalog
        document.querySelectorAll('.btn-sync-catalog').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');
                if (!confirm('Bạn có muốn đồng bộ lại tồn kho và giá nhập từ nhà cung cấp cho các sản phẩm đã import không?')) return;

                const origHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang đồng bộ...';

                try {
                    const res = await fetch(`${baseUrl}/${id}/sync`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const json = await res.json();
                    if (json.success) {
                        alert(json.message);
                        loadProviders();
                    } else {
                        alert(`❌ Lỗi đồng bộ: ${json.error || json.message}`);
                    }
                } catch(e) {
                    alert('Lỗi kết nối khi đồng bộ kho hàng!');
                } finally {
                    this.disabled = false;
                    this.innerHTML = origHtml;
                }
            });
        });

        // Edit
        document.querySelectorAll('.btn-edit-provider').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const prov = providers.find(p => p.id == id);
                if (!prov) return;

                document.getElementById('modal-provider-title').innerHTML = '<i class="ti ti-edit"></i> Chỉnh Sửa Kết Nối API';
                document.getElementById('provider-id').value = prov.id;
                document.getElementById('provider-name').value = prov.name;
                document.getElementById('provider-base-url').value = prov.base_url;
                document.getElementById('provider-auth-type').value = prov.auth_type || 'header';
                document.getElementById('provider-header-name').value = prov.header_name || 'X-API-Key';
                document.getElementById('provider-api-key').value = prov.api_key;
                document.getElementById('provider-partner-id').value = prov.partner_id || '';
                document.getElementById('provider-status').value = prov.status || 'active';
                document.getElementById('provider-ep-catalog').value = prov.endpoint_catalog || '/api/v2/catalog';
                document.getElementById('provider-ep-orders').value = prov.endpoint_orders || '/api/v2/orders';
                document.getElementById('provider-ep-balance').value = prov.endpoint_balance || '/api/v2/me';

                openModal('modal-provider');
            });
        });

        // Delete
        document.querySelectorAll('.btn-delete-provider').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');
                if (!confirm('Bạn có chắc chắn muốn xóa kết nối API này không?')) return;

                try {
                    const res = await fetch(`${baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const json = await res.json();
                    if (json.success) {
                        alert('✅ Đã xóa kết nối API thành công!');
                        loadProviders();
                    } else {
                        alert(`❌ ${json.message}`);
                    }
                } catch(e) {
                    alert('Lỗi khi xóa kết nối!');
                }
            });
        });
    }

    // Modal Helpers
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'flex';
    }
    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }

    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', function() {
            const modalId = this.getAttribute('data-close-modal');
            closeModal(modalId);
        });
    });

    document.querySelectorAll('.ap-modal-backdrop').forEach(bg => {
        bg.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // Provider Presets
    const providerPresets = {
        canboso: {
            name: 'Canboso (@Vincentrrrrr_Bot)',
            base_url: 'https://canboso.com',
            auth_type: 'header',
            header_name: 'x-buyer-key',
            partner_id: '',
            endpoint_catalog: '/api/v2/telegram-buyer/products',
            endpoint_orders: '/api/v2/telegram-buyer/purchase',
            endpoint_balance: '/api/v2/telegram-buyer/balance'
        },
        minhais: {
            name: 'MinhAIS (@minhais_8888_bot)',
            base_url: 'https://api.hminhhosting.io.vn',
            auth_type: 'header',
            header_name: 'X-API-KEY',
            partner_id: '',
            endpoint_catalog: '/api/stock',
            endpoint_orders: '/api/buy',
            endpoint_balance: '/api/stock'
        },
        haji: {
            name: 'Haji Shop (@cataishop_bot)',
            base_url: 'https://api.haji.in.net',
            auth_type: 'header',
            header_name: 'X-API-Key',
            partner_id: '',
            endpoint_catalog: '/api/v2/catalog',
            endpoint_orders: '/api/v2/orders',
            endpoint_balance: '/api/v2/me'
        },
        telestore: {
            name: 'TeleStore (@daupremiumbot)',
            base_url: 'https://botviptele.dpdns.org/api/v1',
            auth_type: 'bearer',
            header_name: 'Authorization',
            partner_id: '',
            endpoint_catalog: '/products',
            endpoint_orders: '/orders',
            endpoint_balance: '/balance'
        }
    };

    document.querySelectorAll('.btn-apply-provider-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const key = this.getAttribute('data-preset');
            const p = providerPresets[key];
            if (!p) return;
            document.getElementById('provider-name').value = p.name;
            document.getElementById('provider-base-url').value = p.base_url;
            document.getElementById('provider-auth-type').value = p.auth_type;
            document.getElementById('provider-header-name').value = p.header_name;
            if (p.partner_id) document.getElementById('provider-partner-id').value = p.partner_id;
            document.getElementById('provider-ep-catalog').value = p.endpoint_catalog;
            document.getElementById('provider-ep-orders').value = p.endpoint_orders;
            document.getElementById('provider-ep-balance').value = p.endpoint_balance;
            document.getElementById('provider-api-key').focus();
        });
    });

    // Open create modal
    document.getElementById('btn-open-create').addEventListener('click', function() {
        document.getElementById('modal-provider-title').innerHTML = '<i class="ti ti-plus"></i> Thêm Kết Nối API Mới';
        document.getElementById('form-provider').reset();
        document.getElementById('provider-id').value = '';
        document.getElementById('provider-header-name').value = 'X-API-Key';
        document.getElementById('provider-ep-catalog').value = '/api/v2/catalog';
        document.getElementById('provider-ep-orders').value = '/api/v2/orders';
        document.getElementById('provider-ep-balance').value = '/api/v2/me';
        openModal('modal-provider');
    });

    // Form submit provider
    document.getElementById('form-provider').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('provider-id').value;
        const btnSave = document.getElementById('btn-save-provider');
        btnSave.disabled = true;
        btnSave.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang lưu & Kiểm tra...';

        const payload = {
            name: document.getElementById('provider-name').value,
            base_url: document.getElementById('provider-base-url').value,
            auth_type: document.getElementById('provider-auth-type').value,
            header_name: document.getElementById('provider-header-name').value,
            api_key: document.getElementById('provider-api-key').value,
            partner_id: document.getElementById('provider-partner-id').value,
            status: document.getElementById('provider-status').value,
            endpoint_catalog: document.getElementById('provider-ep-catalog').value,
            endpoint_orders: document.getElementById('provider-ep-orders').value,
            endpoint_balance: document.getElementById('provider-ep-balance').value,
        };

        const url = id ? `${baseUrl}/${id}` : baseUrl;
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();
            if (json.success) {
                let msg = json.message;
                if (json.ping && json.ping.success) {
                    msg += `\nKết nối thành công! Số dư: ${fmtMoney(json.ping.balance)} ${json.ping.currency}`;
                } else if (json.ping && !json.ping.success) {
                    msg += `\n⚠️ Cảnh báo: Kết nối API chưa thành công (${json.ping.error}). Hãy kiểm tra lại Base URL và API Key!`;
                }
                alert(msg);
                closeModal('modal-provider');
                loadProviders();
            } else {
                alert(`❌ Lỗi: ${json.message || 'Không thể lưu kết nối'}`);
            }
        } catch(e) {
            alert('Lỗi hệ thống khi lưu kết nối API!');
        } finally {
            btnSave.disabled = false;
            btnSave.innerHTML = '<i class="ti ti-check"></i> Lưu & Kiểm Tra Kết Nối';
        }
    });

    // ──────────────────────────── Catalog & Import Modal ────────────────────────────
    async function openCatalogModal(providerId) {
        activeCatalogProviderId = providerId;
        const prov = providers.find(p => p.id == providerId);
        document.getElementById('catalog-title').innerHTML = `<i class="ti ti-packages"></i> Kho Hàng: ${escapeHtml(prov ? prov.name : 'Đối tác')}`;
        document.getElementById('catalog-sub').innerText = `Đang kết nối ${prov ? prov.base_url : ''}...`;

        openModal('modal-catalog');
        const tbody = document.getElementById('tbody-catalog');
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải danh sách hàng từ đối tác...</td></tr>';

        try {
            const res = await fetch(`${baseUrl}/${providerId}/catalog`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const json = await res.json();
            if (json.success) {
                catalogItems = json.products || [];
                document.getElementById('catalog-sub').innerText = `Tìm thấy ${catalogItems.length} sản phẩm. Số dư ví: ${fmtMoney(json.provider.balance)} ${json.provider.currency}`;
                renderCatalogTable();
            } else {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:20px; color:#ef4444;">❌ Lỗi kết nối API: ${json.error || 'Không thể lấy catalog'}</td></tr>`;
            }
        } catch(e) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:20px; color:#ef4444;">Lỗi khi gọi API catalog!</td></tr>';
        }
    }

    function renderCatalogTable() {
        const tbody = document.getElementById('tbody-catalog');
        const q = (document.getElementById('catalog-search').value || '').toLowerCase().trim();
        const filterStock = document.getElementById('catalog-filter-stock').value;

        const filtered = catalogItems.filter(item => {
            const matchQ = !q || (item.name && item.name.toLowerCase().includes(q)) || (item.product_id && item.product_id.toLowerCase().includes(q));
            let matchStock = true;
            if (filterStock === 'available') matchStock = (item.stock_count > 0 || item.available);
            else if (filterStock === 'not_imported') matchStock = !item.imported;
            else if (filterStock === 'imported') matchStock = item.imported;

            return matchQ && matchStock;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:var(--ap-text-sub);">Không tìm thấy sản phẩm nào phù hợp!</td></tr>';
            updateSelectedInfo();
            return;
        }

        const defaultMarkup = parseFloat(document.getElementById('custom-markup-pct').value) || 30;

        tbody.innerHTML = filtered.map(item => {
            const costPrice = parseFloat(item.price || 0);
            const initialSalePrice = item.shop_price ? item.shop_price : Math.round(costPrice * (1 + (defaultMarkup / 100)) / 1000) * 1000;
            const itemIcon = (item.shop_icon !== null && item.shop_icon !== undefined && item.shop_icon !== '') 
                ? item.shop_icon 
                : (item.icon || '5312361253610475399');
            const isInst = item.delivery_mode === 'instant_items';
            const modeBadge = isInst
                ? '<span class="ap-badge ap-badge-cyan" title="Trả tài khoản ngay trong response"><i class="ti ti-bolt"></i> Trả acc ngay</span>'
                : '<span class="ap-badge ap-badge-amber" title="Cần gửi kèm email khách hàng để nâng cấp"><i class="ti ti-user-check"></i> Nâng cấp Email</span>';

            const stockText = item.stock_count > 0
                ? `<span class="ap-badge ap-badge-green"><i class="ti ti-circle-check"></i> ${item.stock_count} cái</span>`
                : `<span class="ap-badge ap-badge-rose"><i class="ti ti-circle-x"></i> Hết hàng</span>`;

            let shopStatus;
            if (item.imported) {
                const isPublished = (item.shop_status !== 'draft');
                shopStatus = isPublished
                    ? `<span class="ap-badge ap-badge-green"><i class="ti ti-circle-check"></i> Đang bán (${fmtMoney(item.shop_price)})</span>`
                    : `<span class="ap-badge ap-badge-amber"><i class="ti ti-eye-off"></i> Tạm ẩn (${fmtMoney(item.shop_price)})</span>`;
            } else {
                shopStatus = `<span class="ap-badge ap-badge-muted"><i class="ti ti-circle-dashed"></i> Chưa nhập</span>`;
            }

            return `
            <tr data-product-id="${item.product_id}">
                <td style="text-align: center;">
                    <input type="checkbox" class="catalog-check-item" data-id="${item.product_id}" style="cursor: pointer; transform: scale(1.15);">
                </td>
                <td style="min-width: 240px;">
                    <div style="font-weight: 700; color: #ffffff !important; font-size: 13px;">${escapeHtml(item.name)}</div>
                    <div style="margin-top: 4px; display: inline-flex; align-items: center; gap: 6px;">
                        <span class="ap-pill-id">ID: ${escapeHtml(item.product_id)}</span>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    <div class="ap-emoji-wrap" title="Dán Emoji hoặc Custom Emoji ID Telegram">
                        <span class="ap-emoji-preview" id="modal-emoji-prev-${item.product_id}">${renderEmojiPreview(itemIcon)}</span>
                        <input type="text" 
                               class="ap-emoji-input modal-item-icon-input" 
                               data-id="${item.product_id}" 
                               value="${escapeHtml(itemIcon)}" 
                               placeholder="Emoji / ID..." 
                               title="Nhập Emoji hoặc Custom Emoji ID">
                        <button type="button" class="ap-emoji-btn btn-open-modal-emoji-popover" data-id="${item.product_id}" title="Chọn nhanh emoji">
                            <i class="ti ti-mood-smile"></i>
                        </button>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">${modeBadge}</td>
                <td style="text-align: center; white-space: nowrap !important;">${stockText}</td>
                <td style="text-align: right; white-space: nowrap !important;" class="ap-mono">
                    <span style="color: #fbbf24 !important; font-weight: 800; font-size: 13px;">${fmtMoney(costPrice)}</span>
                </td>
                <td style="text-align: right; white-space: nowrap !important;">
                    <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 5px; white-space: nowrap !important;">
                        <input type="number" class="live-price-input item-sale-price" data-id="${item.product_id}" data-cost="${costPrice}" value="${initialSalePrice}" step="1000" min="0">
                        <span style="font-size: 12px; color: #94a3b8 !important; font-weight: 600;">đ</span>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">${shopStatus}</td>
            </tr>`;
        }).join('');

        // Attach events
        tbody.querySelectorAll('.catalog-check-item').forEach(ck => {
            ck.addEventListener('change', updateSelectedInfo);
        });

        tbody.querySelectorAll('.modal-item-icon-input').forEach(inp => {
            inp.addEventListener('input', function() {
                const prodId = this.getAttribute('data-id');
                const prev = document.getElementById(`modal-emoji-prev-${prodId}`);
                if (prev) prev.innerHTML = renderEmojiPreview(this.value);
            });
        });

        tbody.querySelectorAll('.btn-open-modal-emoji-popover').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const prodId = this.getAttribute('data-id');
                openGlobalEmojiPicker(this, prodId, true);
            });
        });

        updateSelectedInfo();
    }

    function updateSelectedInfo() {
        const checked = document.querySelectorAll('.catalog-check-item:checked');
        document.getElementById('catalog-selected-info').innerText = `Đã chọn ${checked.length} sản phẩm để import`;
    }

    // Check all
    document.getElementById('check-all-catalog').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.catalog-check-item').forEach(ck => ck.checked = isChecked);
        updateSelectedInfo();
    });

    // Search & filter catalog
    document.getElementById('catalog-search').addEventListener('input', renderCatalogTable);
    document.getElementById('catalog-filter-stock').addEventListener('change', renderCatalogTable);

    // Apply quick markup
    document.querySelectorAll('.btn-apply-markup').forEach(btn => {
        btn.addEventListener('click', function() {
            const pct = parseFloat(this.getAttribute('data-pct'));
            document.getElementById('custom-markup-pct').value = pct;
            applyMarkupToInputs(pct);
        });
    });

    document.getElementById('btn-apply-custom-markup').addEventListener('click', function() {
        const pct = parseFloat(document.getElementById('custom-markup-pct').value) || 0;
        applyMarkupToInputs(pct);
    });

    function applyMarkupToInputs(pct) {
        document.querySelectorAll('.item-sale-price').forEach(inp => {
            const cost = parseFloat(inp.getAttribute('data-cost')) || 0;
            const newSale = Math.round(cost * (1 + (pct / 100)) / 1000) * 1000;
            inp.value = newSale;
        });
    }

    // Do Import Action
    document.getElementById('btn-do-import').addEventListener('click', async function() {
        const checked = Array.from(document.querySelectorAll('.catalog-check-item:checked'));
        if (checked.length === 0) {
            alert('Vui lòng tích chọn ít nhất 1 sản phẩm để import vào shop!');
            return;
        }

        const itemsToImport = [];
        const markupPct = parseFloat(document.getElementById('custom-markup-pct').value) || 0;

        checked.forEach(ck => {
            const prodId = ck.getAttribute('data-id');
            const catItem = catalogItems.find(i => i.product_id == prodId);
            if (!catItem) return;

            const salePriceInput = document.querySelector(`.item-sale-price[data-id="${prodId}"]`);
            const salePrice = salePriceInput ? parseFloat(salePriceInput.value) : (catItem.price * 1.3);
            const iconInput = document.querySelector(`.modal-item-icon-input[data-id="${prodId}"]`);
            const itemIcon = iconInput ? iconInput.value.trim() : (catItem.shop_icon || '5312361253610475399');

            itemsToImport.push({
                product_id: catItem.product_id,
                name: catItem.name,
                cost_price: parseFloat(catItem.price || 0),
                sale_price: salePrice,
                stock_count: catItem.stock_count || 0,
                delivery_mode: catItem.delivery_mode || 'instant_items',
                description: catItem.description || '',
                markup_percent: markupPct,
                icon: itemIcon,
            });
        });

        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang Import...';

        try {
            const res = await fetch(`${baseUrl}/${activeCatalogProviderId}/import`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ items: itemsToImport })
            });

            const json = await res.json();
            if (json.success) {
                alert(`✅ ${json.message}\nCác sản phẩm đã sẵn sàng mở bán trên Telegram Bot (@cataishop_bot)!`);
                closeModal('modal-catalog');
                loadProviders();
            } else {
                alert(`❌ Lỗi Import: ${json.message || 'Không thể import'}`);
            }
        } catch(e) {
            alert('Lỗi kết nối khi import sản phẩm!');
        } finally {
            this.disabled = false;
            this.innerHTML = '<i class="ti ti-download"></i> Import Vào Shop & Mở Bán';
        }
    });

    document.getElementById('btn-refresh-all').addEventListener('click', function() {
        loadProviders();
        if (activeCatalogProviderId) loadLiveCatalog(activeCatalogProviderId);
    });

    // ──────────────────────────── LIVE CATALOG SECTION ────────────────────────────
    function renderProviderTabs() {
        const tabsContainer = document.getElementById('live-catalog-provider-tabs');
        const filterSelect = document.getElementById('live-filter-provider');

        if (filterSelect) {
            let selectHtml = `<option value="all" ${activeCatalogProviderId === 'all' ? 'selected' : ''}>🌐 Tất Cả Nhà Cung Cấp</option>`;
            providers.forEach(p => {
                selectHtml += `<option value="${p.id}" ${activeCatalogProviderId == p.id ? 'selected' : ''}>🏢 ${escapeHtml(p.name)}</option>`;
            });
            filterSelect.innerHTML = selectHtml;
        }

        if (tabsContainer) {
            let tabsHtml = `
                <button type="button" class="ap-provider-tab-btn ${activeCatalogProviderId === 'all' ? 'active' : ''}" data-id="all">
                    <i class="ti ti-world"></i> Tất Cả (${providers.length} Shop)
                </button>
            `;
            providers.forEach(p => {
                const isAct = (activeCatalogProviderId == p.id);
                tabsHtml += `
                    <button type="button" class="ap-provider-tab-btn ${isAct ? 'active' : ''}" data-id="${p.id}">
                        <i class="ti ti-building-store"></i> ${escapeHtml(p.name)}
                    </button>
                `;
            });
            tabsContainer.innerHTML = tabsHtml;

            tabsContainer.querySelectorAll('.ap-provider-tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    loadLiveCatalog(id);
                });
            });
        }
    }

    async function loadLiveCatalog(providerId) {
        activeCatalogProviderId = providerId || 'all';
        renderProviderTabs();

        const nameEl = document.getElementById('live-catalog-provider-name');
        const tbody = document.getElementById('tbody-live-catalog');
        const filterSelect = document.getElementById('live-filter-provider');
        if (filterSelect && filterSelect.value !== String(activeCatalogProviderId)) {
            filterSelect.value = String(activeCatalogProviderId);
        }

        if (activeCatalogProviderId === 'all') {
            if (nameEl) nameEl.innerText = `Kho Hàng Sỉ API: Tất Cả Nhà Cung Cấp (${providers.length} Shop)`;
        } else {
            const prov = providers.find(p => p.id == activeCatalogProviderId);
            if (nameEl) nameEl.innerText = `Kho Hàng Sỉ API: ${prov ? prov.name : 'Đối tác'}`;
        }

        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="11" style="text-align:center; padding:30px; color:var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang kết nối API lấy danh sách hàng...</td></tr>';
        }

        try {
            if (activeCatalogProviderId === 'all') {
                const activeProvs = providers.filter(p => p.status === 'active' || p.status == 1 || p.status === 1);
                if (activeProvs.length === 0) {
                    catalogItems = [];
                    renderLiveCatalog();
                    return;
                }
                const promises = activeProvs.map(async (p) => {
                    try {
                        const res = await fetch(`${baseUrl}/${p.id}/catalog`, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const json = await res.json();
                        if (json.success && Array.isArray(json.products)) {
                            return json.products.map(item => ({
                                ...item,
                                provider_id: p.id,
                                provider_name: p.name
                            }));
                        }
                        return [];
                    } catch {
                        return [];
                    }
                });
                const results = await Promise.all(promises);
                catalogItems = results.flat();
                renderLiveCatalog();
            } else {
                const prov = providers.find(p => p.id == activeCatalogProviderId);
                const res = await fetch(`${baseUrl}/${activeCatalogProviderId}/catalog`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const json = await res.json();
                if (json.success) {
                    catalogItems = (json.products || []).map(item => ({
                        ...item,
                        provider_id: prov ? prov.id : activeCatalogProviderId,
                        provider_name: prov ? prov.name : 'API'
                    }));
                    renderLiveCatalog();
                } else {
                    if (tbody) tbody.innerHTML = `<tr><td colspan="11" style="text-align:center; padding:20px; color:#ef4444;">❌ Lỗi kết nối API: ${json.error || 'Không thể lấy catalog'}</td></tr>`;
                }
            }
        } catch(e) {
            if (tbody) tbody.innerHTML = '<tr><td colspan="11" style="text-align:center; padding:20px; color:#ef4444;">Lỗi khi gọi API catalog!</td></tr>';
        }
    }

    function renderLiveCatalog() {
        const tbody = document.getElementById('tbody-live-catalog');
        if (!tbody) return;

        const countBadge = document.getElementById('live-catalog-count-badge');
        const nameEl = document.getElementById('live-catalog-provider-name');
        const prov = providers.find(p => p.id == activeCatalogProviderId);

        if (nameEl) {
            if (activeCatalogProviderId === 'all') {
                nameEl.innerText = `Kho Hàng Sỉ API: Tất Cả Nhà Cung Cấp (${providers.length} Shop)`;
            } else if (prov) {
                nameEl.innerText = `Kho Hàng Sỉ API: ${prov.name}`;
            }
        }
        if (countBadge) {
            countBadge.innerText = `${catalogItems.length} SP`;
        }

        const q = (document.getElementById('live-search')?.value || '').toLowerCase().trim();
        const filterStock = document.getElementById('live-filter-stock')?.value || 'all';

        const filtered = catalogItems.filter(item => {
            const matchQ = !q || (item.name && item.name.toLowerCase().includes(q)) || (item.product_id && item.product_id.toLowerCase().includes(q)) || (item.provider_name && item.provider_name.toLowerCase().includes(q));
            let matchStock = true;
            if (filterStock === 'available') matchStock = (item.stock_count > 0 || item.available);
            else if (filterStock === 'not_imported') matchStock = !item.imported;
            else if (filterStock === 'imported') matchStock = item.imported;
            else if (filterStock === 'published') matchStock = item.imported && (item.shop_status !== 'draft');
            else if (filterStock === 'draft') matchStock = item.imported && (item.shop_status === 'draft');
            return matchQ && matchStock;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="11" style="text-align:center; padding:30px; color:var(--ap-text-sub);">Không tìm thấy sản phẩm nào phù hợp!</td></tr>';
            updateLiveSelectedCount();
            return;
        }

        const defaultMarkup = parseFloat(document.getElementById('live-markup-pct')?.value) || 30;

        tbody.innerHTML = filtered.map(item => {
            const costPrice = parseFloat(item.price || 0);

            let itemMarkupPct;
            if (item.shop_markup !== null && item.shop_markup !== undefined && item.shop_markup !== '') {
                itemMarkupPct = parseFloat(item.shop_markup);
            } else if (item.shop_price && costPrice > 0) {
                itemMarkupPct = Math.round(((parseFloat(item.shop_price) - costPrice) / costPrice) * 100);
            } else {
                itemMarkupPct = defaultMarkup;
            }

            let salePrice;
            if (item.shop_price) {
                salePrice = parseFloat(item.shop_price);
            } else {
                salePrice = Math.round(costPrice * (1 + (itemMarkupPct / 100)) / 1000) * 1000;
            }

            const diffAmount = salePrice - costPrice;
            const diffSign = diffAmount >= 0 ? '+' : '';

            const itemIcon = (item.shop_icon !== null && item.shop_icon !== undefined && item.shop_icon !== '') 
                ? item.shop_icon 
                : (item.icon || '5312361253610475399');

            const isInst = item.delivery_mode === 'instant_items';
            const modeBadge = isInst
                ? '<span class="ap-badge ap-badge-cyan" title="Trả tài khoản ngay trong response đặt hàng"><i class="ti ti-bolt"></i> Trả acc ngay</span>'
                : '<span class="ap-badge ap-badge-amber" title="Cần gửi kèm email khách hàng để xử lý"><i class="ti ti-user-check"></i> Nâng cấp email</span>';

            const stockText = (item.stock_count > 0 || item.available)
                ? `<span class="ap-badge ap-badge-green"><i class="ti ti-check"></i> ${item.stock_count > 0 ? item.stock_count + ' cái' : 'Còn hàng'}</span>`
                : `<span class="ap-badge ap-badge-rose"><i class="ti ti-x"></i> Hết hàng</span>`;

            let shopStatus;
            if (item.imported) {
                const isPublished = (item.shop_status !== 'draft');
                shopStatus = isPublished
                    ? `<button type="button" class="ap-badge ap-badge-green ap-status-btn btn-toggle-shop-status" data-id="${item.product_id}" data-current="published" title="🟢 Đang BẬT BÁN trên Bot Telegram. Bấm để TẠM ẨN (Ngừng bán)"><i class="ti ti-circle-check"></i> Đang bán</button>`
                    : `<button type="button" class="ap-badge ap-badge-amber ap-status-btn btn-toggle-shop-status" data-id="${item.product_id}" data-current="draft" title="🟡 Đang TẠM ẨN trên Bot (Khách không thấy). Bấm để MỞ BÁN lại"><i class="ti ti-eye-off"></i> Tạm ẩn</button>`;
            } else {
                shopStatus = `<span class="ap-badge" style="background: rgba(255,255,255,0.06); color: var(--ap-text-muted);" title="Chưa được lưu vào kho shop"><i class="ti ti-circle-dashed"></i> Chưa lưu</span>`;
            }

            return `
            <tr data-product-id="${item.product_id}">
                <td style="text-align: center;">
                    <input type="checkbox" class="live-check-item" data-id="${item.product_id}" style="cursor: pointer; transform: scale(1.15);">
                </td>
                <td style="min-width: 240px;">
                    <div style="font-weight: 700; color: #ffffff !important; font-size: 13px; line-height: 1.4;">${escapeHtml(item.name)}</div>
                    <div style="margin-top: 4px; display: inline-flex; align-items: center; gap: 6px;">
                        <span class="ap-pill-id">ID: ${escapeHtml(item.product_id)}</span>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    <span class="ap-badge" style="background: rgba(56, 189, 248, 0.12) !important; color: #38bdf8 !important; border: 1px solid rgba(56, 189, 248, 0.3) !important; font-size: 11px;">
                        <i class="ti ti-building-store"></i> ${escapeHtml(item.provider_name || 'API')}
                    </span>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    <div class="ap-emoji-wrap" title="Dán Emoji (🤖, ⚡, 💎) hoặc Custom Emoji ID từ Telegram (ví dụ: 5312361253610475399)">
                        <span class="ap-emoji-preview" id="emoji-prev-${item.product_id}">${renderEmojiPreview(itemIcon)}</span>
                        <input type="text" 
                                class="ap-emoji-input item-icon-input" 
                                data-id="${item.product_id}" 
                                value="${escapeHtml(itemIcon)}" 
                                placeholder="Emoji / ID..." 
                                title="Nhập Emoji hoặc Custom Emoji ID Telegram">
                        <button type="button" class="ap-emoji-btn btn-open-emoji-popover" data-id="${item.product_id}" title="Chọn nhanh emoji">
                            <i class="ti ti-mood-smile"></i>
                        </button>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    ${modeBadge}
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    ${stockText}
                </td>
                <td style="text-align: right; white-space: nowrap !important;" class="ap-mono">
                    <div style="color: #fbbf24 !important; font-weight: 800; font-size: 13px;">${fmtMoney(costPrice)}</div>
                    <div style="font-size: 10px; color: #94a3b8 !important;">Giá sỉ tạm</div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    <div class="ap-markup-cell" title="Chỉnh % lãi chênh lệch so với giá sỉ để tự động tính tiền lãi và giá bán lẻ">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 3px;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 700;">+</span>
                            <input type="number" class="item-markup-pct" data-id="${item.product_id}" data-cost="${costPrice}" value="${itemMarkupPct}" min="0" max="1000" step="1">
                            <span style="font-size: 12px; color: #38bdf8; font-weight: 700;">%</span>
                        </div>
                        <div class="item-diff-badge" id="diff-badge-${item.product_id}">${diffSign}${fmtMoney(diffAmount)}</div>
                    </div>
                </td>
                <td style="text-align: right; white-space: nowrap !important;">
                    <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 5px; white-space: nowrap !important;">
                        <input type="number" class="live-price-input" data-id="${item.product_id}" data-cost="${costPrice}" value="${salePrice}" step="1000" min="0">
                        <span style="font-size: 12px; color: #94a3b8 !important; font-weight: 600;">đ</span>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    ${shopStatus}
                </td>
                <td style="text-align: right; white-space: nowrap !important;">
                    <div style="display: flex; justify-content: flex-end; gap: 6px;">
                        ${item.imported ? `
                            <button type="button" class="ap-btn ap-btn-sm ap-btn-emerald btn-live-import-one" data-id="${item.product_id}" title="Lưu cấu hình mức lãi, icon & cập nhật giá bán lẻ mới">
                                <i class="ti ti-device-floppy"></i> Lưu
                            </button>
                            <button type="button" class="ap-btn ap-btn-sm ap-btn-rose btn-live-unlink-one" data-id="${item.product_id}" title="Loại bỏ / Gỡ sản phẩm này ra khỏi shop (Hủy lưu, không còn bán trên Bot)">
                                <i class="ti ti-trash"></i> Gỡ bỏ
                            </button>
                        ` : `
                            <button type="button" class="ap-btn ap-btn-sm ap-btn-primary btn-live-import-one" data-id="${item.product_id}" title="Lưu mức lãi, icon & nhập bán trên Bot ngay">
                                <i class="ti ti-download"></i> Lưu & Bán
                            </button>
                        `}
                    </div>
                </td>
            </tr>`;
        }).join('');

        bindLiveCatalogEvents();
        updateLiveSelectedCount();
    }

    function bindLiveCatalogEvents() {
        const tbody = document.getElementById('tbody-live-catalog');
        if (!tbody) return;

        // Checkboxes
        tbody.querySelectorAll('.live-check-item').forEach(ck => {
            ck.addEventListener('change', updateLiveSelectedCount);
        });

        // Emoji input live preview change
        tbody.querySelectorAll('.item-icon-input').forEach(inp => {
            inp.addEventListener('input', function() {
                const prodId = this.getAttribute('data-id');
                const prev = document.getElementById(`emoji-prev-${prodId}`);
                if (prev) prev.innerHTML = renderEmojiPreview(this.value);
            });
        });

        // Open emoji popover for this row
        tbody.querySelectorAll('.btn-open-emoji-popover').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const prodId = this.getAttribute('data-id');
                openGlobalEmojiPicker(this, prodId, false);
            });
        });

        // Two-way dynamic calculation: Markup % -> Sale price & Diff badge
        tbody.querySelectorAll('.item-markup-pct').forEach(inp => {
            inp.addEventListener('input', function() {
                const pct = parseFloat(this.value) || 0;
                const cost = parseFloat(this.getAttribute('data-cost')) || 0;
                const diff = Math.round((cost * (pct / 100)) / 1000) * 1000;
                const sale = cost + diff;
                const prodId = this.getAttribute('data-id');
                const priceInp = document.querySelector(`.live-price-input[data-id="${prodId}"]`);
                const badge = document.getElementById(`diff-badge-${prodId}`);
                if (priceInp) priceInp.value = sale;
                if (badge) badge.innerText = `${diff >= 0 ? '+' : ''}${fmtMoney(diff)}`;
            });
        });

        // Two-way dynamic calculation: Sale price -> Markup % & Diff badge
        tbody.querySelectorAll('.live-price-input').forEach(inp => {
            inp.addEventListener('input', function() {
                const sale = parseFloat(this.value) || 0;
                const cost = parseFloat(this.getAttribute('data-cost')) || 0;
                const diff = sale - cost;
                const pct = cost > 0 ? Math.round((diff / cost) * 100) : 0;
                const prodId = this.getAttribute('data-id');
                const pctInp = document.querySelector(`.item-markup-pct[data-id="${prodId}"]`);
                const badge = document.getElementById(`diff-badge-${prodId}`);
                if (pctInp) pctInp.value = pct >= 0 ? pct : 0;
                if (badge) badge.innerText = `${diff >= 0 ? '+' : ''}${fmtMoney(diff)}`;
            });
        });

        // Single item save action
        tbody.querySelectorAll('.btn-live-import-one').forEach(btn => {
            btn.addEventListener('click', async function() {
                const prodId = this.getAttribute('data-id');
                const catItem = catalogItems.find(i => i.product_id == prodId);
                if (!catItem) return;

                const inputEl = document.querySelector(`.live-price-input[data-id="${prodId}"]`);
                const markupEl = document.querySelector(`.item-markup-pct[data-id="${prodId}"]`);
                const iconEl = document.querySelector(`.item-icon-input[data-id="${prodId}"]`);
                const costPrice = parseFloat(catItem.price || 0);
                const markupPct = markupEl ? (parseFloat(markupEl.value) || 0) : 30;
                const salePrice = inputEl ? (parseFloat(inputEl.value) || (costPrice * 1.3)) : (costPrice * 1.3);
                const itemIcon = iconEl ? iconEl.value.trim() : (catItem.shop_icon || '5312361253610475399');

                const origHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang lưu...';

                const provId = catItem.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);

                try {
                    const res = await fetch(`${baseUrl}/${provId}/import`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            items: [{
                                product_id: catItem.product_id,
                                name: catItem.name,
                                cost_price: costPrice,
                                sale_price: salePrice,
                                stock_count: catItem.stock_count || 0,
                                delivery_mode: catItem.delivery_mode || 'instant_items',
                                description: catItem.description || '',
                                markup_percent: markupPct,
                                icon: itemIcon,
                            }]
                        })
                    });
                    const json = await res.json();
                    if (json.success) {
                        alert(`✅ ${json.message}\nSản phẩm "${catItem.name}" đã được cập nhật giá bán ${fmtMoney(salePrice)} (Mức lãi: +${markupPct}% = +${fmtMoney(salePrice - costPrice)}) và Icon: "${itemIcon}"!`);
                        catItem.imported = true;
                        catItem.shop_price = salePrice;
                        catItem.shop_markup = markupPct;
                        catItem.shop_icon = itemIcon;
                        catItem.shop_status = 'published';
                        renderLiveCatalog();
                        loadProviders();
                    } else {
                        alert(`❌ Lỗi lưu sản phẩm: ${json.message || 'Thất bại'}`);
                    }
                } catch(e) {
                    alert('Lỗi kết nối khi lưu sản phẩm!');
                } finally {
                    this.disabled = false;
                    this.innerHTML = origHtml;
                }
            });
        });

        // Toggle single product status (published <-> draft)
        tbody.querySelectorAll('.btn-toggle-shop-status').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.stopPropagation();
                const prodId = this.getAttribute('data-id');
                const catItem = catalogItems.find(i => i.product_id == prodId);
                if (!catItem) return;

                const provId = catItem.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!provId) return;

                const origHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="ti ti-loader ap-spin"></i>';

                try {
                    const res = await fetch(`${baseUrl}/${provId}/toggle-product-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: prodId })
                    });
                    const json = await res.json();
                    if (json.success) {
                        catItem.shop_status = json.status;
                        renderLiveCatalog();
                    } else {
                        alert(`❌ ${json.message || 'Không thể đổi trạng thái'}`);
                        this.disabled = false;
                        this.innerHTML = origHtml;
                    }
                } catch(err) {
                    alert('Lỗi kết nối khi đổi trạng thái!');
                    this.disabled = false;
                    this.innerHTML = origHtml;
                }
            });
        });

        // Unlink / remove single product from shop
        tbody.querySelectorAll('.btn-live-unlink-one').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.stopPropagation();
                const prodId = this.getAttribute('data-id');
                const catItem = catalogItems.find(i => i.product_id == prodId);
                if (!catItem) return;

                const provId = catItem.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!provId) return;

                if (!confirm(`Bạn có chắc chắn muốn LOẠI BỎ sản phẩm "${catItem.name}" ra khỏi shop không?\n\nSau khi loại bỏ, sản phẩm sẽ không còn được bán trên Bot và chuyển về trạng thái Chưa lưu.`)) {
                    return;
                }

                const origHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<i class="ti ti-loader ap-spin"></i>';

                try {
                    const res = await fetch(`${baseUrl}/${provId}/unlink-product`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: prodId })
                    });
                    const json = await res.json();
                    if (json.success) {
                        alert(`✅ ${json.message}`);
                        catItem.imported = false;
                        catItem.shop_status = null;
                        catItem.shop_price = null;
                        catItem.shop_markup = null;
                        renderLiveCatalog();
                        loadProviders();
                    } else {
                        alert(`❌ ${json.message || 'Không thể loại bỏ sản phẩm'}`);
                    }
                } catch(err) {
                    alert('Lỗi kết nối khi gỡ sản phẩm!');
                } finally {
                    this.disabled = false;
                    this.innerHTML = origHtml;
                }
            });
        });
    }

    function updateLiveSelectedCount() {
        const checked = document.querySelectorAll('.live-check-item:checked');
        const countEl = document.getElementById('live-selected-count');
        if (countEl) countEl.innerText = checked.length;
    }

    // Check all live items
    document.getElementById('live-check-all')?.addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.live-check-item').forEach(ck => ck.checked = isChecked);
        updateLiveSelectedCount();
    });

    // Search and filter live catalog
    document.getElementById('live-search')?.addEventListener('input', renderLiveCatalog);
    document.getElementById('live-filter-stock')?.addEventListener('change', renderLiveCatalog);
    document.getElementById('live-filter-provider')?.addEventListener('change', function() {
        loadLiveCatalog(this.value);
    });

    // Dynamic markup calculation: Quick buttons and Global Input
    document.querySelectorAll('.btn-apply-quick-markup').forEach(btn => {
        btn.addEventListener('click', function() {
            const pct = parseFloat(this.getAttribute('data-pct'));
            const mainInp = document.getElementById('live-markup-pct');
            if (mainInp) mainInp.value = pct;
            applyMarkupToAllLive(pct);
        });
    });

    document.getElementById('live-markup-pct')?.addEventListener('input', function() {
        const pct = parseFloat(this.value) || 0;
        applyMarkupToAllLive(pct);
    });

    function applyMarkupToAllLive(pct) {
        document.querySelectorAll('#tbody-live-catalog .item-markup-pct').forEach(inp => {
            inp.value = pct;
            const cost = parseFloat(inp.getAttribute('data-cost')) || 0;
            const diff = Math.round((cost * (pct / 100)) / 1000) * 1000;
            const sale = cost + diff;
            const prodId = inp.getAttribute('data-id');
            const priceInp = document.querySelector(`.live-price-input[data-id="${prodId}"]`);
            const badge = document.getElementById(`diff-badge-${prodId}`);
            if (priceInp) priceInp.value = sale;
            if (badge) badge.innerText = `${diff >= 0 ? '+' : ''}${fmtMoney(diff)}`;
        });
    }

    // Sync Catalog & Recalculate Prices
    document.getElementById('btn-live-sync-catalog')?.addEventListener('click', async function() {
        if (!confirm('Hệ thống sẽ lấy giá sỉ và tồn kho mới nhất từ API, đồng thời tự động tính lại giá bán lẻ theo mức % lãi đã cấu hình. Bạn có chắc chắn muốn đồng bộ?')) {
            return;
        }

        const origHtml = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang đồng bộ...';

        try {
            if (activeCatalogProviderId === 'all') {
                const activeProvs = providers.filter(p => p.status === 'active' || p.status == 1 || p.status === 1);
                for (const p of activeProvs) {
                    await fetch(`${baseUrl}/${p.id}/sync`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                }
                alert('✅ Đã đồng bộ thành công kho sỉ từ tất cả các nhà cung cấp!');
            } else {
                const res = await fetch(`${baseUrl}/${activeCatalogProviderId}/sync`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const json = await res.json();
                if (json.success) {
                    alert(`✅ ${json.message}`);
                } else {
                    alert(`❌ Lỗi đồng bộ: ${json.error || json.message}`);
                }
            }
            loadLiveCatalog(activeCatalogProviderId);
            loadProviders();
        } catch(e) {
            alert('Lỗi kết nối khi đồng bộ giá sỉ!');
        } finally {
            this.disabled = false;
            this.innerHTML = origHtml;
        }
    });

    // Bulk Save / Import button
    document.getElementById('btn-live-bulk-import')?.addEventListener('click', async function() {
        const checked = Array.from(document.querySelectorAll('.live-check-item:checked'));
        if (checked.length === 0) {
            alert('Vui lòng tích chọn ít nhất 1 sản phẩm để lưu cấu hình / import vào shop!');
            return;
        }

        const itemsToImport = [];
        const fallbackMarkup = parseFloat(document.getElementById('live-markup-pct')?.value) || 30;

        checked.forEach(ck => {
            const prodId = ck.getAttribute('data-id');
            const catItem = catalogItems.find(i => i.product_id == prodId);
            if (!catItem) return;

            const priceEl = document.querySelector(`.live-price-input[data-id="${prodId}"]`);
            const markupEl = document.querySelector(`.item-markup-pct[data-id="${prodId}"]`);
            const iconEl = document.querySelector(`.item-icon-input[data-id="${prodId}"]`);
            const costPrice = parseFloat(catItem.price || 0);
            const markupPct = markupEl ? (parseFloat(markupEl.value) || 0) : fallbackMarkup;
            const salePrice = priceEl ? (parseFloat(priceEl.value) || (costPrice * 1.3)) : (costPrice * 1.3);
            const itemIcon = iconEl ? iconEl.value.trim() : (catItem.shop_icon || '5312361253610475399');

            itemsToImport.push({
                product_id: catItem.product_id,
                name: catItem.name,
                cost_price: costPrice,
                sale_price: salePrice,
                stock_count: catItem.stock_count || 0,
                delivery_mode: catItem.delivery_mode || 'instant_items',
                description: catItem.description || '',
                markup_percent: markupPct,
                icon: itemIcon,
                provider_id: catItem.provider_id,
            });
        });

        const origHtml = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang lưu ' + itemsToImport.length + ' SP...';

        try {
            const groups = {};
            itemsToImport.forEach(item => {
                const pId = item.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!groups[pId]) groups[pId] = [];
                groups[pId].push(item);
            });

            let totalImported = 0;
            for (const [pId, pItems] of Object.entries(groups)) {
                const res = await fetch(`${baseUrl}/${pId}/import`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ items: pItems })
                });

                const json = await res.json();
                if (json.success) {
                    totalImported += pItems.length;
                    pItems.forEach(imp => {
                        const found = catalogItems.find(i => i.product_id == imp.product_id);
                        if (found) {
                            found.imported = true;
                            found.shop_price = imp.sale_price;
                            found.shop_markup = imp.markup_percent;
                            found.shop_icon = imp.icon;
                            found.shop_status = 'published';
                        }
                    });
                }
            }

            alert(`✅ Đã lưu cấu hình và mở bán ${totalImported} sản phẩm thành công trên Telegram Bot!`);
            renderLiveCatalog();
            loadProviders();
        } catch(e) {
            alert('Lỗi kết nối khi import sản phẩm: ' + e.message);
        } finally {
            this.disabled = false;
            this.innerHTML = origHtml;
        }
    });

    // Bulk Publish (Bật bán trên Bot)
    document.getElementById('btn-live-bulk-publish')?.addEventListener('click', async function() {
        const checked = Array.from(document.querySelectorAll('.live-check-item:checked'));
        if (checked.length === 0) {
            alert('Vui lòng tích chọn ít nhất 1 sản phẩm để BẬT BÁN!');
            return;
        }

        const ids = checked.map(ck => ck.getAttribute('data-id')).filter(Boolean);
        const importedIds = ids.filter(id => {
            const item = catalogItems.find(i => i.product_id == id);
            return item && item.imported;
        });

        if (importedIds.length === 0) {
            alert('Các sản phẩm được chọn chưa được lưu vào shop. Vui lòng bấm "Lưu / Bán Đã Chọn" trước!');
            return;
        }

        const origHtml = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang bật bán...';

        try {
            const groups = {};
            importedIds.forEach(id => {
                const item = catalogItems.find(i => i.product_id == id);
                const pId = item?.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!groups[pId]) groups[pId] = [];
                groups[pId].push(id);
            });

            for (const [pId, pIds] of Object.entries(groups)) {
                await fetch(`${baseUrl}/${pId}/bulk-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ product_ids: pIds, status: 'published' })
                });
            }

            alert(`✅ Đã bật bán ${importedIds.length} sản phẩm thành công trên Telegram Bot!`);
            importedIds.forEach(id => {
                const found = catalogItems.find(i => i.product_id == id);
                if (found) found.shop_status = 'published';
            });
            renderLiveCatalog();
        } catch(e) {
            alert('Lỗi kết nối khi bật bán!');
        } finally {
            this.disabled = false;
            this.innerHTML = origHtml;
        }
    });

    // Bulk Draft (Tạm ẩn / Ngừng bán trên Bot)
    document.getElementById('btn-live-bulk-draft')?.addEventListener('click', async function() {
        const checked = Array.from(document.querySelectorAll('.live-check-item:checked'));
        if (checked.length === 0) {
            alert('Vui lòng tích chọn ít nhất 1 sản phẩm để TẠM ẨN!');
            return;
        }

        const ids = checked.map(ck => ck.getAttribute('data-id')).filter(Boolean);
        const importedIds = ids.filter(id => {
            const item = catalogItems.find(i => i.product_id == id);
            return item && item.imported;
        });

        if (importedIds.length === 0) {
            alert('Các sản phẩm được chọn chưa được lưu vào shop!');
            return;
        }

        const origHtml = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang tạm ẩn...';

        try {
            const groups = {};
            importedIds.forEach(id => {
                const item = catalogItems.find(i => i.product_id == id);
                const pId = item?.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!groups[pId]) groups[pId] = [];
                groups[pId].push(id);
            });

            for (const [pId, pIds] of Object.entries(groups)) {
                await fetch(`${baseUrl}/${pId}/bulk-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ product_ids: pIds, status: 'draft' })
                });
            }

            alert(`✅ Đã tạm ẩn ${importedIds.length} sản phẩm thành công trên Telegram Bot!`);
            importedIds.forEach(id => {
                const found = catalogItems.find(i => i.product_id == id);
                if (found) found.shop_status = 'draft';
            });
            renderLiveCatalog();
        } catch(e) {
            alert('Lỗi kết nối khi tạm ẩn!');
        } finally {
            this.disabled = false;
            this.innerHTML = origHtml;
        }
    });

    // Bulk Unlink (Loại bỏ / Gỡ khỏi shop)
    document.getElementById('btn-live-bulk-unlink')?.addEventListener('click', async function() {
        const checked = Array.from(document.querySelectorAll('.live-check-item:checked'));
        if (checked.length === 0) {
            alert('Vui lòng tích chọn ít nhất 1 sản phẩm để gỡ khỏi shop!');
            return;
        }

        const ids = checked.map(ck => ck.getAttribute('data-id')).filter(Boolean);
        const importedIds = ids.filter(id => {
            const item = catalogItems.find(i => i.product_id == id);
            return item && item.imported;
        });

        if (importedIds.length === 0) {
            alert('Trong các mục đã chọn, không có sản phẩm nào đang được lưu trong shop!');
            return;
        }

        if (!confirm(`Bạn có chắc chắn muốn LOẠI BỎ ${importedIds.length} sản phẩm đã chọn ra khỏi shop không?\n\nSau khi loại bỏ, các sản phẩm này sẽ không còn xuất hiện trên Bot và trở về trạng thái Chưa lưu.`)) {
            return;
        }

        const origHtml = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="ti ti-loader ap-spin"></i> Đang gỡ bỏ ' + importedIds.length + ' SP...';

        try {
            const groups = {};
            importedIds.forEach(id => {
                const item = catalogItems.find(i => i.product_id == id);
                const pId = item?.provider_id || (activeCatalogProviderId !== 'all' ? activeCatalogProviderId : providers[0]?.id);
                if (!groups[pId]) groups[pId] = [];
                groups[pId].push(id);
            });

            for (const [pId, pIds] of Object.entries(groups)) {
                await fetch(`${baseUrl}/${pId}/unlink-product`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ product_ids: pIds })
                });
            }

            alert(`✅ Đã loại bỏ ${importedIds.length} sản phẩm ra khỏi shop thành công!`);
            importedIds.forEach(id => {
                const found = catalogItems.find(i => i.product_id == id);
                if (found) {
                    found.imported = false;
                    found.shop_status = null;
                    found.shop_price = null;
                    found.shop_markup = null;
                }
            });
            renderLiveCatalog();
            loadProviders();
        } catch(e) {
            alert('Lỗi kết nối khi gỡ sản phẩm!');
        } finally {
            this.disabled = false;
            this.innerHTML = origHtml;
        }
    });

    // ──────────────────────────── API ORDERS & STATS ────────────────────────────
    async function loadApiOrders(page = 1, search = '') {
        ordersCurrentPage = page;
        ordersSearchQuery = search;

        const tbody = document.getElementById('tbody-api-orders');
        if (!tbody) return;

        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 30px; color: var(--ap-text-sub);"><i class="ti ti-loader ap-spin"></i> Đang tải danh sách đơn hàng API...</td></tr>';

        try {
            const targetId = 'all';
            const url = `${baseUrl}/${targetId}/orders?page=${page}&search=${encodeURIComponent(search)}`;
            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const json = await res.json();

            if (json.success) {
                if (json.stats) {
                    apiStats = json.stats;
                    updateKpis();
                }
                renderApiOrders(json.orders);
            } else {
                tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 20px; color: #ef4444;">❌ Lỗi: ${json.error || 'Không thể tải đơn hàng'}</td></tr>`;
            }
        } catch(e) {
            console.error('Error fetching API orders:', e);
            tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 20px; color: #ef4444;">Lỗi kết nối tải đơn hàng API!</td></tr>`;
        }
    }

    function renderApiOrders(ordersData) {
        const tbody = document.getElementById('tbody-api-orders');
        if (!tbody) return;

        const items = ordersData.data || [];
        const countBadge = document.getElementById('orders-count-badge');
        if (countBadge) countBadge.innerText = `${ordersData.total || 0} Đơn`;

        const infoEl = document.getElementById('orders-pagination-info');
        if (infoEl) infoEl.innerText = `Hiển thị ${items.length} trên tổng ${ordersData.total || 0} đơn hàng API`;

        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 30px; color: var(--ap-text-sub);">Chưa có đơn hàng nào mua qua API!</td></tr>';
            renderOrdersPagination(ordersData);
            return;
        }

        const startIdx = ((ordersData.current_page || 1) - 1) * (ordersData.per_page || 15);

        tbody.innerHTML = items.map((ord, idx) => {
            const stt = startIdx + idx + 1;
            const profit = ord.profit || 0;
            const profitPct = ord.profit_pct || 0;
            const isProfitable = profit >= 0;

            return `
            <tr>
                <td class="ap-mono" style="text-align: center; color: #94a3b8 !important; font-weight: 600;">${stt}</td>
                <td>
                    <div style="font-weight: 700; color: #ffffff !important; font-size: 13px;">${escapeHtml(ord.code)}</div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 3px;">
                        Mã API: <code style="color: #38bdf8;">${escapeHtml(ord.api_order_code)}</code>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 600; color: #f1f5f9 !important; font-size: 13px;">${escapeHtml(ord.product_name)}</div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 2px;">
                        Số lượng: <b style="color: #ffffff;">${ord.quantity}</b> cái
                    </div>
                </td>
                <td>
                    <div style="font-weight: 600; color: #c7d2fe !important; font-size: 12px;">${escapeHtml(ord.customer_name)}</div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 2px;" class="ap-mono">
                        ID: ${escapeHtml(ord.customer_tg_id)}
                    </div>
                </td>
                <td style="text-align: right; white-space: nowrap !important;" class="ap-mono">
                    <span style="color: #fbbf24 !important; font-weight: 700; font-size: 13px;">${fmtMoney(ord.cost)}</span>
                </td>
                <td style="text-align: right; white-space: nowrap !important;" class="ap-mono">
                    <span style="color: #f1f5f9 !important; font-weight: 700; font-size: 13px;">${fmtMoney(ord.revenue)}</span>
                </td>
                <td style="text-align: right; white-space: nowrap !important;" class="ap-mono">
                    <div style="font-size: 14px; font-weight: 800; color: ${isProfitable ? '#34d399' : '#fb7185'} !important;">
                        ${isProfitable ? '+' : ''}${fmtMoney(profit)}
                    </div>
                    <div style="font-size: 11px; color: #94a3b8 !important; margin-top: 2px;">
                        Lãi: <span style="color: #38bdf8; font-weight: 700;">+${profitPct}%</span>
                    </div>
                </td>
                <td style="text-align: center; white-space: nowrap !important;">
                    ${getOrderStatusBadge(ord.status)}
                </td>
                <td style="text-align: right; white-space: nowrap !important; font-size: 12px; color: #94a3b8;">
                    ${fmtDate(ord.created_at)}
                </td>
            </tr>`;
        }).join('');

        renderOrdersPagination(ordersData);
    }

    function renderOrdersPagination(ordersData) {
        const btnsWrap = document.getElementById('orders-pagination-btns');
        if (!btnsWrap) return;

        const cur = ordersData.current_page || 1;
        const last = ordersData.last_page || 1;

        if (last <= 1) {
            btnsWrap.innerHTML = '';
            return;
        }

        let html = '';
        if (cur > 1) {
            html += `<button type="button" class="ap-pagination-btn" data-page="${cur - 1}"><i class="ti ti-chevron-left"></i> Trước</button>`;
        }

        for (let p = Math.max(1, cur - 2); p <= Math.min(last, cur + 2); p++) {
            const activeStyle = (p === cur) ? 'background: #3b82f6 !important; border-color: #3b82f6 !important;' : '';
            html += `<button type="button" class="ap-pagination-btn" data-page="${p}" style="${activeStyle}">${p}</button>`;
        }

        if (cur < last) {
            html += `<button type="button" class="ap-pagination-btn" data-page="${cur + 1}">Sau <i class="ti ti-chevron-right"></i></button>`;
        }

        btnsWrap.innerHTML = html;

        btnsWrap.querySelectorAll('.ap-pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const p = parseInt(this.getAttribute('data-page'));
                if (p && p !== ordersCurrentPage) {
                    loadApiOrders(p, ordersSearchQuery);
                }
            });
        });
    }

    function getOrderStatusBadge(status) {
        switch (status) {
            case 'completed':
                return '<span class="ap-badge ap-badge-green"><i class="ti ti-circle-check"></i> Hoàn thành</span>';
            case 'paid':
                return '<span class="ap-badge ap-badge-cyan"><i class="ti ti-check"></i> Đã thanh toán</span>';
            case 'processing':
                return '<span class="ap-badge ap-badge-cyan"><i class="ti ti-loader ap-spin"></i> Đang xử lý</span>';
            case 'pending':
                return '<span class="ap-badge ap-badge-amber"><i class="ti ti-clock"></i> Chờ xử lý</span>';
            case 'failed':
                return '<span class="ap-badge ap-badge-rose"><i class="ti ti-alert-triangle"></i> Lỗi API</span>';
            case 'cancelled':
                return '<span class="ap-badge ap-badge-rose"><i class="ti ti-ban"></i> Đã hủy</span>';
            default:
                return `<span class="ap-badge ap-badge-purple">${escapeHtml(status || 'Hoàn tất')}</span>`;
        }
    }

    function fmtDate(d) {
        if (!d) return '--';
        try {
            const dt = new Date(d);
            if (isNaN(dt.getTime())) return d;
            return dt.toLocaleString('vi-VN', {
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                day: '2-digit', month: '2-digit', year: 'numeric'
            });
        } catch(e) {
            return d;
        }
    }

    let orderSearchTimer = null;
    document.getElementById('orders-search')?.addEventListener('input', function() {
        clearTimeout(orderSearchTimer);
        const q = this.value.trim();
        orderSearchTimer = setTimeout(() => {
            loadApiOrders(1, q);
        }, 400);
    });

    document.getElementById('btn-refresh-orders')?.addEventListener('click', function() {
        loadApiOrders(ordersCurrentPage, ordersSearchQuery);
    });

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Init
    initGlobalEmojiPicker();

    if (providers && providers.length > 0) {
        renderProviders();
        updateKpis();
    } else {
        loadProviders();
    }

    if (catalogItems && catalogItems.length > 0) {
        renderLiveCatalog();
    } else if (activeCatalogProviderId) {
        loadLiveCatalog(activeCatalogProviderId);
    }

    // Load API orders on init
    loadApiOrders(1);
})();
</script>
@endpush
