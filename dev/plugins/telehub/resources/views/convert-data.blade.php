@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<style>
    #convert-data-app {
        --primary: #7c3aed;
        --primary-light: #8b5cf6;
        --primary-glow: rgba(124, 58, 237, 0.4);
        --secondary: #ec4899;
        --accent: #06b6d4;
        --bg: #05070f;
        --surface: rgba(15, 20, 40, 0.85);
        --surface2: rgba(255, 255, 255, 0.04);
        --surface3: rgba(255, 255, 255, 0.07);
        --text: #f0f4ff;
        --text-dim: #8892b0;
        --text-muted: #4a5568;
        --border: rgba(255, 255, 255, 0.08);
        --border-focus: rgba(124, 58, 237, 0.6);
        --success: #10b981;
        --danger: #ef4444;
        --excel: #1d6f42;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
        --radius-xl: 24px;

        background-color: var(--bg);
        background-image:
            radial-gradient(ellipse at 15% 10%, rgba(124, 58, 237, 0.2) 0%, transparent 50%),
            radial-gradient(ellipse at 85% 90%, rgba(236, 72, 153, 0.12) 0%, transparent 50%),
            radial-gradient(ellipse at 50% 50%, rgba(6, 182, 212, 0.04) 0%, transparent 60%);
        color: var(--text);
        padding: 24px 16px;
        border-radius: var(--radius-xl);
        font-family: 'Inter', sans-serif;
    }

    #convert-data-app * {
        box-sizing: border-box;
    }

    #convert-data-app header {
        text-align: center;
        margin-bottom: 24px;
        padding: 32px 24px 28px;
        background: var(--surface);
        backdrop-filter: blur(24px);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
    }

    #convert-data-app header::before {
        content: '';
        position: absolute;
        inset: -1px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.5), rgba(236, 72, 153, 0.3), rgba(6, 182, 212, 0.2));
        border-radius: var(--radius-xl);
        z-index: -1;
        opacity: 0.6;
    }

    #convert-data-app header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(124, 58, 237, 0.8), rgba(236, 72, 153, 0.8), transparent);
    }

    #convert-data-app h1 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff 20%, var(--primary-light) 60%, var(--secondary));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    #convert-data-app .subtitle {
        color: var(--text-dim);
        font-size: 0.9rem;
        font-weight: 400;
    }

    #convert-data-app .c-card {
        background: var(--surface);
        backdrop-filter: blur(24px);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 20px;
        margin-bottom: 16px;
        position: relative;
    }

    #convert-data-app .c-card-title {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #convert-data-app .c-card-title .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary-light);
        box-shadow: 0 0 8px var(--primary-light);
        flex-shrink: 0;
    }

    #convert-data-app .product-top-row {
        display: flex;
        gap: 10px;
        margin-bottom: 14px;
    }

    #convert-data-app .product-input {
        flex: 1;
        background: var(--surface2);
        border: 1px solid var(--border);
        padding: 10px 14px;
        border-radius: var(--radius-md);
        color: var(--text);
        font-size: 0.9rem;
        outline: none;
        transition: all 0.2s;
        min-width: 0;
    }

    #convert-data-app .product-input:focus {
        border-color: var(--border-focus);
        background: var(--surface3);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
    }

    #convert-data-app .btn-add-product {
        padding: 10px 16px;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-size: 0.85rem;
        background: linear-gradient(135deg, var(--primary) 0%, #6d28d9 100%);
        color: white;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    #convert-data-app .btn-add-product:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px -4px var(--primary-glow);
        filter: brightness(1.1);
    }

    #convert-data-app .chip-groups {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #convert-data-app .chip-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    #convert-data-app .chip-group-label {
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        padding-left: 2px;
    }

    #convert-data-app .chip-group-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    #convert-data-app .chip-wrap {
        display: inline-flex;
        align-items: center;
        gap: 0;
    }

    #convert-data-app .suggestion-chip {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text-dim);
        padding: 5px 12px;
        border-radius: 20px 0 0 20px;
        font-size: 0.78rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
        font-weight: 500;
        line-height: 1.4;
        white-space: nowrap;
    }

    #convert-data-app .suggestion-chip.no-delete {
        border-radius: 20px;
    }

    #convert-data-app .suggestion-chip:hover {
        background: rgba(124, 58, 237, 0.12);
        color: var(--text);
        border-color: rgba(124, 58, 237, 0.4);
    }

    #convert-data-app .suggestion-chip.active {
        background: linear-gradient(135deg, var(--primary) 0%, #6d28d9 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 10px var(--primary-glow);
    }

    #convert-data-app .chip-delete {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-left: none;
        color: var(--text-muted);
        padding: 5px 8px;
        border-radius: 0 20px 20px 0;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        line-height: 1;
    }

    #convert-data-app .chip-delete:hover {
        background: rgba(239, 68, 68, 0.15);
        color: var(--danger);
        border-color: rgba(239, 68, 68, 0.3);
    }

    #convert-data-app .main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        #convert-data-app .main-grid {
            grid-template-columns: 1fr;
        }
    }

    #convert-data-app .io-section {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #convert-data-app .label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #convert-data-app .section-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    #convert-data-app .count-badge {
        background: rgba(124, 58, 237, 0.12);
        color: var(--primary-light);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid rgba(124, 58, 237, 0.2);
    }

    #convert-data-app .count-badge.success {
        background: rgba(16, 185, 129, 0.12);
        color: var(--success);
        border-color: rgba(16, 185, 129, 0.25);
    }

    #convert-data-app textarea {
        width: 100%;
        height: 260px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        color: var(--text);
        font-size: 0.88rem;
        line-height: 1.65;
        resize: none;
        transition: all 0.2s;
        outline: none;
        font-family: 'Inter', monospace;
    }

    #convert-data-app textarea:focus {
        border-color: var(--border-focus);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1), 0 0 20px rgba(124, 58, 237, 0.08);
        background: var(--surface3);
    }

    #convert-data-app #outputData {
        cursor: default;
    }

    #convert-data-app .controls-card {
        background: var(--surface);
        backdrop-filter: blur(24px);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 16px 20px;
        margin-bottom: 16px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    #convert-data-app button {
        padding: 11px 22px;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        font-size: 0.88rem;
        font-family: 'Inter', sans-serif;
    }

    #convert-data-app .btn-convert {
        background: linear-gradient(135deg, var(--primary) 0%, #6d28d9 100%);
        color: white;
        box-shadow: 0 6px 20px -6px var(--primary);
    }

    #convert-data-app .btn-convert:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 28px -6px var(--primary);
        filter: brightness(1.1);
    }

    #convert-data-app .btn-clear {
        background: var(--surface2);
        color: var(--text-dim);
        border: 1px solid var(--border);
    }

    #convert-data-app .btn-clear:hover {
        background: var(--surface3);
        color: var(--text);
        border-color: var(--text-muted);
    }

    #convert-data-app .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    #convert-data-app .btn-copy {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        color: white;
        justify-content: center;
    }

    #convert-data-app .btn-copy:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -6px var(--success);
    }

    #convert-data-app .btn-excel {
        background: linear-gradient(135deg, var(--excel) 0%, #145230 100%);
        color: white;
        justify-content: center;
    }

    #convert-data-app .btn-excel:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -6px var(--excel);
    }

    #convert-data-app .btn-copy.copied {
        background: #fff;
        color: var(--success);
    }

    #convert-data-app .info-card {
        background: rgba(124, 58, 237, 0.05);
        border-radius: var(--radius-lg);
        border: 1px dashed rgba(124, 58, 237, 0.3);
        padding: 14px 18px;
        font-size: 0.82rem;
        color: var(--text-dim);
        line-height: 1.6;
    }

    #convert-data-app .info-card code {
        background: rgba(0, 0, 0, 0.3);
        padding: 2px 6px;
        border-radius: 4px;
        color: var(--primary-light);
        font-size: 0.8rem;
    }

    #convert-data-app .mode-tabs {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 16px;
    }

    #convert-data-app .mode-tab {
        color: var(--text-dim);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 6px 16px;
        border: 1px solid var(--border);
        border-radius: 20px;
        display: inline-block;
        transition: all 0.2s;
        cursor: pointer;
        background: transparent;
    }

    #convert-data-app .mode-tab:hover {
        border-color: var(--primary-light);
        color: var(--text);
    }

    #convert-data-app .mode-tab.active {
        color: var(--primary-light);
        border-color: var(--primary-light);
        background: rgba(124, 58, 237, 0.1);
    }

    #convert-data-app .c-modal {
        position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000;
        display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);
    }
    #convert-data-app .c-modal-content {
        background: var(--surface); border: 1px solid var(--border);
        padding: 24px; border-radius: var(--radius-lg); width: 550px; max-width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    #convert-data-app .format-item {
        display: flex; justify-content: space-between; padding: 12px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); margin-bottom: 8px; align-items: center;
    }
    #convert-data-app .format-item-del { color: var(--danger); cursor: pointer; border:none; background:none; font-weight:bold; padding: 5px 10px; }
    #convert-data-app .format-item-del:hover { background: rgba(239, 68, 68, 0.15); border-radius: 4px; }
</style>

<div id="convert-data-app">
    <!-- HEADER -->
    <header>
        <h1 id="app-title">⚡ Tool Formatter Data</h1>
        <p class="subtitle" id="app-subtitle">Chuyển đổi dữ liệu & Xuất Excel chuyên nghiệp</p>
        <div class="mode-tabs">
            <button class="mode-tab active" id="tab-excel" onclick="setMode('excel')">Xuất Excel / Format</button>
            <button class="mode-tab" id="tab-mail" onclick="setMode('mail')">Lọc Mail Only</button>
        </div>
    </header>

    <!-- PRODUCT PICKER (Only in Excel Mode) -->
    <div class="c-card" id="productPickerCard">
        <div class="c-card-title"><span class="dot"></span>Tên Sản Phẩm</div>

        <div class="product-top-row">
            <input type="text" id="productName" class="product-input" value="Sản phẩm mặc định"
                placeholder="Nhập tên sản phẩm mới..." oninput="syncProductNameChips()">
            <button class="btn-add-product" onclick="addCustomProduct()">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Thêm mới
            </button>
        </div>

        <div class="format-picker-row" id="formatPickerRow" style="margin-bottom: 14px; display: flex; gap: 10px; align-items: flex-end;">
            <div style="flex: 1;">
                <label style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 6px;">Định dạng (Format)</label>
                <select id="formatSelect" class="product-input" style="width: 100%; cursor: pointer;"></select>
            </div>
            <button class="btn-clear" onclick="openFormatModal()">
                ⚙ Quản lý Format
            </button>
        </div>

        <div class="chip-groups" id="chipGroups">
            <!-- rendered by JS -->
        </div>
    </div>

    <!-- MAIN IO GRID -->
    <div class="main-grid">

        <!-- INPUT -->
        <div class="c-card io-section">
            <div class="label-row">
                <span class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dữ liệu thô
                </span>
                <span class="count-badge" id="inputCount">0 Dòng</span>
            </div>
            <textarea id="inputData" placeholder="Dán dữ liệu vào đây...&#10;Email&#9;PassMail&#9;PassGPT&#9;2FA"
                oninput="updateInputCount()"></textarea>
        </div>

        <!-- OUTPUT -->
        <div class="c-card io-section">
            <div class="label-row">
                <span class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Kết quả
                </span>
                <span class="count-badge success" id="outputCount">0 Tài khoản</span>
            </div>
            <textarea id="outputData" readonly placeholder="Kết quả sẽ hiển thị ở đây..."></textarea>
            <div class="action-buttons">
                <button class="btn-copy" id="copyBtn" onclick="copyResult()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    Copy
                </button>
                <button class="btn-excel" id="excelBtn" onclick="exportToExcel()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Xuất Excel
                </button>
            </div>
        </div>

    </div>

    <!-- CONTROLS -->
    <div class="controls-card">
        <button class="btn-convert" onclick="processData()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Chuyển đổi ngay
        </button>
        <button class="btn-clear" onclick="clearAll()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Xóa tất cả
        </button>
    </div>

    <!-- INFO -->
    <div class="info-card" id="infoCard">
        <strong>Hướng dẫn Excel:</strong> File sẽ có 4 cột: <code>Product</code>, <code>Username</code>,
        <code>Password</code>, <code>Note</code>.
        Nhập tên sản phẩm mới vào ô trên rồi nhấn <strong>Thêm mới</strong> để lưu vào danh sách gợi ý.
    </div>

    <!-- FORMAT MODAL -->
    <div id="formatModal" class="c-modal" style="display:none;">
        <div class="c-modal-content">
            <h3 style="margin-top:0; margin-bottom: 16px; color: var(--text);">Quản lý Format</h3>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" id="newFormatName" placeholder="Tên format (vd: Key KBH)" class="product-input" style="flex:1;">
                <input type="text" id="newFormatCols" placeholder="Ví dụ: U,P,N" class="product-input" style="width: 120px;" title="U=Username, P=Password, N=Note, I=Bỏ qua">
            </div>
            <textarea id="newFormatNoteTemplate" placeholder="Mẫu Ghi chú (tùy chọn) - Dùng {1}, {2}, {3}... để lấy dữ liệu từng cột tương ứng&#10;Ví dụ: Mail: {1}&#10;Pass GPT: {2} | 2FA: {3}" class="product-input" style="width: 100%; height: 80px; margin-bottom: 10px; resize: none; font-size: 0.85rem; font-family: monospace;"></textarea>
            <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
                <button class="btn-convert" onclick="addFormat()">Thêm</button>
            </div>
            <div style="font-size: 0.8rem; color: var(--text-dim); margin-bottom: 16px; line-height: 1.5;">
                Nhập chuỗi định dạng bằng các chữ cái cách nhau bởi dấu phẩy:<br>
                <b>U</b> = Username, <b>P</b> = Password, <b>N</b> = Note, <b>I</b> = Bỏ qua.<br>
                <i>Ví dụ: Dạng Key là <b>U</b>. Dạng thông thường là <b>U,P,N</b></i>
            </div>
            <div id="formatList" style="max-height: 250px; overflow-y: auto; padding-right: 5px;"></div>
            <div style="text-align: right; margin-top: 20px;">
                <button class="btn-clear" onclick="closeFormatModal()">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    let mode = 'excel'; // 'excel' or 'mail'
    let accountsList = [];

    // Lấy dữ liệu sản phẩm từ biến $products đã truyền sang Blade
    const dbProducts = @json($products->pluck('name'));

    // Phân loại sản phẩm thông minh
    const systemGroups = [
        { label: 'ChatGPT · KAKAO', items: [], regex: /chatgpt.*kakao/i },
        { label: 'ChatGPT · VN / UPI', items: [], regex: /chatgpt.*(vn|upi)/i },
        { label: 'ChatGPT', items: [], regex: /chatgpt/i },
        { label: 'Capcut', items: [], regex: /capcut/i },
        { label: 'Grok', items: [], regex: /grok/i },
        { label: 'Khác', items: [], regex: /.*/ }
    ];

    dbProducts.forEach(name => {
        for (let group of systemGroups) {
            if (group.regex.test(name)) {
                group.items.push(name);
                break; // Chỉ thêm vào nhóm phù hợp đầu tiên
            }
        }
    });

    const defaultGroups = systemGroups.filter(g => g.items.length > 0);

    if (dbProducts.length > 0) {
        document.getElementById('productName').value = dbProducts[0];
    }

    let customProducts = JSON.parse(localStorage.getItem('customProducts') || '[]');

    function saveCustom() {
        localStorage.setItem('customProducts', JSON.stringify(customProducts));
    }

    function getAllGroups() {
        const groups = defaultGroups.map(g => ({ label: g.label, items: [...g.items], isDefault: true }));
        if (customProducts.length > 0) {
            groups.push({ label: 'Tùy chỉnh (Đã thêm)', items: [...customProducts], isDefault: false });
        }
        return groups;
    }

    function renderChips() {
        const container = document.getElementById('chipGroups');
        const currentVal = document.getElementById('productName').value;
        const groups = getAllGroups();

        container.innerHTML = '';

        groups.forEach(group => {
            if (group.items.length === 0) return;

            const groupEl = document.createElement('div');
            groupEl.className = 'chip-group';

            const labelEl = document.createElement('div');
            labelEl.className = 'chip-group-label';
            labelEl.textContent = group.label;
            groupEl.appendChild(labelEl);

            const rowEl = document.createElement('div');
            rowEl.className = 'chip-group-row';

            group.items.forEach(name => {
                const wrap = document.createElement('span');
                wrap.className = 'chip-wrap';

                const chip = document.createElement('span');
                chip.className = 'suggestion-chip';
                if (group.isDefault) {
                    chip.classList.add('no-delete');
                }
                chip.textContent = name;
                chip.onclick = () => setProductName(chip, name);

                if (!group.isDefault) {
                    chip.style.borderRadius = '20px 0 0 20px';
                } else {
                    chip.style.borderRadius = '20px';
                }

                if (name === currentVal) chip.classList.add('active');

                wrap.appendChild(chip);

                if (!group.isDefault) {
                    const del = document.createElement('button');
                    del.className = 'chip-delete';
                    del.title = 'Xóa';
                    del.innerHTML = '✕';
                    del.onclick = (e) => {
                        e.stopPropagation();
                        deleteCustomProduct(name);
                    };
                    wrap.appendChild(del);
                }

                rowEl.appendChild(wrap);
            });

            groupEl.appendChild(rowEl);
            container.appendChild(groupEl);
        });
    }

    function addCustomProduct() {
        const val = document.getElementById('productName').value.trim();
        if (!val) return;

        const allDefaults = defaultGroups.flatMap(g => g.items);
        if (allDefaults.includes(val) || customProducts.includes(val)) {
            syncProductNameChips();
            return;
        }

        customProducts.push(val);
        saveCustom();
        renderChips();
    }

    function deleteCustomProduct(name) {
        customProducts = customProducts.filter(p => p !== name);
        saveCustom();
        renderChips();
    }

    function setProductName(el, name) {
        document.getElementById('productName').value = name;
        syncProductNameChips();
        autoSelectFormat();
    }

    const defaultFormats = [
        { id: 'default', name: 'Mặc định (User | Pass | Note)', cols: 'U,P,N' },
        { id: 'key_only', name: 'Dạng Key (Chỉ Username)', cols: 'U' },
        { id: 'chatgpt', name: 'ChatGPT (Mail | Pass... | 2FA)', cols: 'U,P,N' },
        { id: 'capcut', name: 'Capcut (Mail | Pass | Note...)', cols: 'U,P,N' },
        { id: 'grok', name: 'Grok (Mail | Pass | Note...)', cols: 'U,P,N' }
    ];
    let customFormats = JSON.parse(localStorage.getItem('customFormats') || '[]');

    function renderFormatSelect() {
        const select = document.getElementById('formatSelect');
        const prevValue = select.value;
        select.innerHTML = '';
        const all = [...defaultFormats, ...customFormats];
        all.forEach(f => {
            const opt = document.createElement('option');
            opt.value = f.id;
            opt.textContent = `${f.name} [ ${f.cols} ]`;
            select.appendChild(opt);
        });
        if (prevValue && all.some(f => f.id === prevValue)) {
            select.value = prevValue;
        } else {
            autoSelectFormat();
        }
    }

    function autoSelectFormat() {
        const lowerName = document.getElementById('productName').value.trim().toLowerCase();
        const select = document.getElementById('formatSelect');
        if (lowerName.includes('chatgpt')) select.value = 'chatgpt';
        else if (lowerName.includes('capcut')) select.value = 'capcut';
        else if (lowerName.includes('grok')) select.value = 'grok';
        else select.value = 'default';
    }

    function addFormat() {
        const name = document.getElementById('newFormatName').value.trim();
        const cols = document.getElementById('newFormatCols').value.trim().toUpperCase();
        const noteTpl = document.getElementById('newFormatNoteTemplate').value.trim();
        if(!name || !cols) return alert('Vui lòng nhập đủ tên và định dạng cột!');
        
        if (!/^[UPNI](,[UPNI])*$/.test(cols.replace(/\s+/g, ''))) {
             return alert('Định dạng cột không hợp lệ. Chỉ chấp nhận U, P, N, I cách nhau bởi dấu phẩy (vd: U,P,N).');
        }

        customFormats.push({ id: 'custom_' + Date.now(), name, cols: cols.replace(/\s+/g, ''), noteTpl });
        localStorage.setItem('customFormats', JSON.stringify(customFormats));
        document.getElementById('newFormatName').value = '';
        document.getElementById('newFormatCols').value = '';
        document.getElementById('newFormatNoteTemplate').value = '';
        renderFormatSelect();
        renderFormatList();
    }

    function deleteFormat(id) {
        if(!confirm('Bạn có chắc muốn xóa format này?')) return;
        customFormats = customFormats.filter(f => f.id !== id);
        localStorage.setItem('customFormats', JSON.stringify(customFormats));
        renderFormatSelect();
        renderFormatList();
    }

    function renderFormatList() {
        const container = document.getElementById('formatList');
        container.innerHTML = '';
        customFormats.forEach(f => {
            const div = document.createElement('div');
            div.className = 'format-item';
            div.innerHTML = `
                <div>
                    <strong style="color:var(--primary-light)">${f.name}</strong><br>
                    <small style="color:var(--text-muted)">Cột: ${f.cols}</small>
                    ${f.noteTpl ? `<br><small style="color:var(--text-dim); display:inline-block; margin-top:4px;">Mẫu: ${f.noteTpl.replace(/\n/g, '<br>')}</small>` : ''}
                </div>
                <button class="format-item-del" onclick="deleteFormat('${f.id}')">✕ Xóa</button>
            `;
            container.appendChild(div);
        });
        if(customFormats.length === 0) {
            container.innerHTML = '<div style="color:var(--text-dim); text-align:center; padding:10px;">Chưa có format tùy chỉnh nào. Bạn có thể thêm ở phía trên.</div>';
        }
    }

    function openFormatModal() {
        document.getElementById('formatModal').style.display = 'flex';
        renderFormatList();
    }
    function closeFormatModal() {
        document.getElementById('formatModal').style.display = 'none';
    }

    function syncProductNameChips() {
        const val = document.getElementById('productName').value;
        document.querySelectorAll('.suggestion-chip').forEach(chip => {
            if (chip.textContent === val) {
                chip.classList.add('active');
            } else {
                chip.classList.remove('active');
            }
        });
    }

    function setMode(newMode) {
        mode = newMode;
        
        document.getElementById('tab-excel').classList.remove('active');
        document.getElementById('tab-mail').classList.remove('active');
        document.getElementById('tab-' + mode).classList.add('active');

        if (mode === 'excel') {
            document.getElementById('app-title').innerText = '⚡ Tool Formatter Data';
            document.getElementById('app-subtitle').innerText = 'Chuyển đổi dữ liệu & Xuất Excel chuyên nghiệp';
            document.getElementById('productPickerCard').style.display = 'block';
            document.getElementById('excelBtn').style.display = 'inline-flex';
            document.getElementById('infoCard').innerHTML = `<strong>Hướng dẫn Excel:</strong> File sẽ có 4 cột: <code>Product</code>, <code>Username</code>, <code>Password</code>, <code>Note</code>. Nhập tên sản phẩm mới vào ô trên rồi nhấn <strong>Thêm mới</strong> để lưu vào danh sách gợi ý.`;
            document.getElementById('inputData').placeholder = "Dán dữ liệu vào đây...\nEmail\tPassMail\tPassGPT\t2FA";
        } else {
            document.getElementById('app-title').innerText = '⚡ Tool Lọc Mail';
            document.getElementById('app-subtitle').innerText = 'Lọc nhanh dữ liệu lấy định dạng Mail';
            document.getElementById('productPickerCard').style.display = 'none';
            document.getElementById('excelBtn').style.display = 'none';
            document.getElementById('infoCard').innerHTML = `<strong>Hướng dẫn:</strong> Dán dữ liệu thô vào, hệ thống sẽ lọc ra định dạng <code>Mail</code> (bỏ Pass).`;
            document.getElementById('inputData').placeholder = "Dán dữ liệu vào đây...";
        }

        clearAll();
    }

    function updateInputCount() {
        const input = document.getElementById('inputData').value.trim();
        const count = input ? input.split('\n').filter(l => l.trim()).length : 0;
        document.getElementById('inputCount').innerText = count + ' Dòng';
    }

    function processData() {
        const input = document.getElementById('inputData').value.trim();
        if (!input) return;

        const lines = input.split(/\r?\n/);
        let resultText = '';
        accountsList = [];
        let validCount = 0;

        if (mode === 'excel') {
            const productName = document.getElementById('productName').value.trim();
            const currentFormatId = document.getElementById('formatSelect').value;
            const allFormats = [...defaultFormats, ...customFormats];
            const format = allFormats.find(f => f.id === currentFormatId) || defaultFormats[0];

            lines.forEach(line => {
                if (!line.trim()) return;

                let parts = [];
                // Hỗ trợ chia cột bằng | hoặc Tab hoặc Khoảng trắng, lọc bỏ cột trống do thừa tab
                if (line.includes('|')) {
                    parts = line.split('|').map(p => p.trim()).filter(p => p !== '');
                } else if (line.includes('\t')) {
                    parts = line.split('\t').map(p => p.trim()).filter(p => p !== '');
                } else {
                    parts = line.trim().split(/\s+/).filter(p => p !== '');
                }

                let email = '';
                let pass = '';
                let note = '';

                if (format.noteTpl) {
                    const colMapping = format.cols.split(',');
                    for (let i = 0; i < parts.length; i++) {
                        const mapTo = colMapping[i] || 'I';
                        if (mapTo === 'U' && !email) email = parts[i];
                        else if (mapTo === 'P' && !pass) pass = parts[i];
                    }
                    
                    let renderedNote = format.noteTpl;
                    for (let i = 0; i < parts.length; i++) {
                        renderedNote = renderedNote.replace(new RegExp(`\\{${i+1}\\}`, 'g'), parts[i] || '');
                    }
                    note = renderedNote;

                } else if (['capcut', 'grok', 'default', 'chatgpt'].includes(format.id)) {
                    if (parts.length >= 2) {
                        email = parts[0];
                        pass = parts[1];
                        if (parts.length > 2) note = parts.slice(2).join('|');
                    } else if (parts.length === 1) {
                        email = parts[0];
                    }
                } else {
                    // Custom format mapping logic without Note Template
                    const colMapping = format.cols.split(',');
                    let noteArr = [];
                    for (let i = 0; i < parts.length; i++) {
                        const mapTo = colMapping[i] || 'N';
                        if (mapTo === 'U' && !email) email = parts[i];
                        else if (mapTo === 'P' && !pass) pass = parts[i];
                        else if (mapTo === 'N') noteArr.push(parts[i]);
                        else if (mapTo === 'I') { /* ignore */ }
                    }
                    note = noteArr.join('|');
                }

                if (email || pass || note) {
                    let outLine = '';
                    if (format.noteTpl) {
                        outLine = note + '\n';
                    } else {
                        outLine = note ? `${email}|${pass}|${note}` : `${email}|${pass}`;
                    }

                    resultText += outLine + '\n';

                    accountsList.push({
                        "Product": productName,
                        "Username": email,
                        "Password": pass,
                        "Note": note
                    });
                    validCount++;
                }
            });
        } else {
            // Mode Lọc Mail
            lines.forEach(line => {
                if (!line.trim()) return;

                let parts = [];
                if (line.includes('|')) {
                    parts = line.split('|').map(p => p.trim());
                } else {
                    parts = line.trim().split(/\s+/);
                }

                if (parts.length >= 1) {
                    resultText += `${parts[0]}\n`;
                    validCount++;
                }
            });
        }

        document.getElementById('outputData').value = resultText.trim();
        document.getElementById('outputCount').innerText = `${validCount} ${mode === 'excel' ? 'Tài khoản' : 'Dòng'}`;
        document.getElementById('outputData').scrollTop = 0;
    }

    async function copyResult() {
        const output = document.getElementById('outputData').value;
        if (!output) return;
        try {
            await navigator.clipboard.writeText(output);
            const btn = document.getElementById('copyBtn');
            const orig = btn.innerHTML;
            btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Đã chép!`;
            btn.classList.add('copied');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
        } catch (err) {
            console.error('Lỗi copy:', err);
        }
    }

    function exportToExcel() {
        if (accountsList.length === 0) {
            alert('Không có dữ liệu để xuất! Hãy chạy chuyển đổi trước.');
            return;
        }
        try {
            const ws = XLSX.utils.json_to_sheet(accountsList);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Accounts");
            XLSX.writeFile(wb, "Data_CatAiShop.xlsx");
        } catch (err) {
            console.error('Lỗi xuất Excel:', err);
            alert('Lỗi xuất Excel! Vui lòng thử lại.');
        }
    }

    function clearAll() {
        document.getElementById('inputData').value = '';
        document.getElementById('outputData').value = '';
        accountsList = [];
        updateInputCount();
        document.getElementById('outputCount').innerText = mode === 'excel' ? '0 Tài khoản' : '0 Dòng';
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        renderChips();
        renderFormatSelect();
        setMode('excel');
    });
</script>

@endsection
