{{-- Metabox hiển thị danh sách combo của sản phẩm hiện tại --}}
<div class="mt-2" id="combo-deals-wrapper">
    {{-- Header toolbar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="text-muted small">Tổng cộng <strong id="combo-total-count">0</strong> combo</span>
        </div>
        <x-core::button
            type="button"
            color="success"
            size="sm"
            class="btn-create-combo"
            icon="ti ti-plus"
            data-bs-toggle="modal"
            data-bs-target="#editComboModal"
        >
            Thêm Combo mới
        </x-core::button>
    </div>

    {{-- Combo list --}}
    <div id="combo-list-container">
        <div class="text-center text-muted py-3" id="combo-loading">
            <div class="spinner-border spinner-border-sm me-1"></div> Đang tải...
        </div>
        <div id="combo-list-content" class="d-none">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px">SL tối thiểu</th>
                            <th class="text-center" style="width:110px">Loại</th>
                            <th>Ưu đãi</th>
                            <th>Nhãn</th>
                            <th class="text-center" style="width:80px">Trạng thái</th>
                            <th class="text-center" style="width:120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="combo-table-body">
                    </tbody>
                </table>
            </div>
        </div>
        <div id="combo-empty" class="d-none">
            <x-core::alert type="info" class="py-2 mb-0">
                <x-core::icon name="ti ti-info-circle" class="me-1" />
                Chưa có combo nào. <a href="#" data-bs-toggle="modal" data-bs-target="#editComboModal" class="btn-create-combo">Tạo combo đầu tiên →</a>
            </x-core::alert>
        </div>
    </div>
</div>

<x-core::modal id="editComboModal" title="Quản lý Combo Deals" button-id="save-combo-btn" button-label="Lưu Combo">
    <div id="edit-combo-wrapper">
        <input type="hidden" id="edit-combo-id">
        <input type="hidden" id="edit-combo-product-id" value="{{ $product->id }}">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Số lượng mua tối thiểu</label>
                <input type="number" id="edit-combo-min-qty" class="form-control" value="2" min="2" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Loại ưu đãi</label>
                <select id="edit-combo-type" class="form-select" required>
                    <option value="discount">Giảm giá</option>
                    <option value="bonus">Tặng thêm acc</option>
                </select>
            </div>
        </div>

        <div class="row" id="combo-discount-fields">
            <div class="col-md-6 mb-3">
                <label class="form-label">Giảm % / 1 acc</label>
                <input type="number" id="edit-combo-discount-percent" class="form-control" min="0" max="100" placeholder="VD: 10">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Giảm tiền mặt / 1 acc (VNĐ)</label>
                <input type="number" id="edit-combo-discount-amount" class="form-control" min="0" placeholder="VD: 5000">
                <small class="text-muted">Chỉ nhập 1 trong 2 (% hoặc VNĐ)</small>
            </div>
        </div>

        <div class="row d-none" id="combo-bonus-fields">
            <div class="col-md-12 mb-3">
                <label class="form-label required">Số lượng acc tặng thêm</label>
                <input type="number" id="edit-combo-bonus-qty" class="form-control" min="1" placeholder="VD: 1">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nhãn hiển thị (Label)</label>
            <input type="text" id="edit-combo-label" class="form-control" placeholder="VD: Mua 10 tặng 1">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Thứ tự sắp xếp</label>
                <input type="number" id="edit-combo-sort" class="form-control" value="0">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">&nbsp;</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" id="edit-combo-active" checked>
                    <label class="form-check-label" for="edit-combo-active">Kích hoạt</label>
                </div>
            </div>
        </div>
    </div>
</x-core::modal>

<div class="d-none">
    <span id="tpl-icon-edit"><x-core::icon name="ti ti-edit" /></span>
    <span id="tpl-icon-trash"><x-core::icon name="ti ti-trash" /></span>
</div>

<script>
(function () {
    var PRODUCT_ID = {{ $product->id }};
    var API_URL    = '{{ route('telehub.product-combos.by-product', $product->id) }}';
    var STORE_URL  = '{{ route('telehub.product-combos.store') }}';
    var UPDATE_URL_BASE = '{{ route('telehub.product-combos.update', '_ID_') }}';
    var CSRF       = '{{ csrf_token() }}';

    var EDIT_ICON = document.getElementById('tpl-icon-edit').innerHTML;
    var TRASH_ICON = document.getElementById('tpl-icon-trash').innerHTML;

    function escapeHtml(text) {
        if (!text) return '';
        return text.toString().replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function formatOffer(combo) {
        if (combo.type === 'bonus') {
            return '<span class="badge bg-success fs-6">🎁 Tặng ' + combo.bonus_qty + ' acc</span>';
        }
        if (combo.discount_percent > 0) {
            return '<span class="badge bg-warning text-dark fs-6">🏷️ -' + combo.discount_percent + '%/acc</span>';
        }
        var amt = parseInt(combo.discount_amount || 0).toLocaleString('vi-VN');
        return '<span class="badge bg-warning text-dark fs-6">🏷️ -' + amt + 'đ/acc</span>';
    }

    function renderCombos(combos) {
        var tbody = document.getElementById('combo-table-body');
        tbody.innerHTML = '';

        if (!combos || combos.length === 0) {
            document.getElementById('combo-list-content').classList.add('d-none');
            document.getElementById('combo-empty').classList.remove('d-none');
            document.getElementById('combo-total-count').textContent = '0';
            return;
        }

        document.getElementById('combo-empty').classList.add('d-none');
        document.getElementById('combo-list-content').classList.remove('d-none');
        document.getElementById('combo-total-count').textContent = combos.length;

        combos.forEach(function (c) {
            var tr = document.createElement('tr');
            var statusBadge = c.is_active
                ? '<span class="badge bg-success">Bật</span>'
                : '<span class="badge bg-secondary">Tắt</span>';

            // Dùng data attrs để nạp vào modal
            var editBtn = '<button type="button" class="btn btn-sm btn-icon btn-primary btn-edit-combo" ' +
                'data-id="' + c.id + '" ' +
                'data-min-qty="' + c.min_quantity + '" ' +
                'data-type="' + c.type + '" ' +
                'data-discount-percent="' + (c.discount_percent || '') + '" ' +
                'data-discount-amount="' + (c.discount_amount || '') + '" ' +
                'data-bonus-qty="' + (c.bonus_qty || '') + '" ' +
                'data-label="' + escapeHtml(c.label || '') + '" ' +
                'data-sort="' + (c.sort_order || 0) + '" ' +
                'data-active="' + c.is_active + '" ' +
                'data-bs-toggle="modal" data-bs-target="#editComboModal" title="Sửa">' + EDIT_ICON + '</button>';

            tr.innerHTML = [
                '<td class="text-center fw-bold">≥ ' + c.min_quantity + '</td>',
                '<td class="text-center">' + (c.type === 'bonus' ? '🎁 Tặng acc' : '🏷️ Giảm giá') + '</td>',
                '<td>' + formatOffer(c) + '</td>',
                '<td><small class="text-muted">' + escapeHtml(c.label || '—') + '</small></td>',
                '<td class="text-center">' + statusBadge + '</td>',
                '<td class="text-center">' +
                    editBtn +
                    '<a href="#" class="btn btn-sm btn-icon btn-danger btn-delete-combo" data-url="' + c.delete_url + '" role="button" title="Xóa">' + TRASH_ICON + '</a>' +
                '</td>',
            ].join('');
            tbody.appendChild(tr);
        });
    }

    function loadCombos() {
        document.getElementById('combo-loading').classList.remove('d-none');
        document.getElementById('combo-list-content').classList.add('d-none');
        document.getElementById('combo-empty').classList.add('d-none');

        fetch(API_URL, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function (r) { return r.json(); })
        .then(function (json) {
            document.getElementById('combo-loading').classList.add('d-none');
            renderCombos(json.data || []);
        })
        .catch(function () {
            document.getElementById('combo-loading').classList.add('d-none');
            document.getElementById('combo-empty').classList.remove('d-none');
        });
    }

    // Toggle fields based on combo type
    $('#edit-combo-type').on('change', function() {
        var type = $(this).val();
        if (type === 'bonus') {
            $('#combo-bonus-fields').removeClass('d-none');
            $('#combo-discount-fields').addClass('d-none');
            $('#edit-combo-discount-percent').val('');
            $('#edit-combo-discount-amount').val('');
        } else {
            $('#combo-discount-fields').removeClass('d-none');
            $('#combo-bonus-fields').addClass('d-none');
            $('#edit-combo-bonus-qty').val('');
        }
    });

    // Handle Create button click
    $(document).on('click', '.btn-create-combo', function() {
        $('#edit-combo-id').val('');
        $('#edit-combo-min-qty').val(2);
        $('#edit-combo-type').val('discount').trigger('change');
        $('#edit-combo-discount-percent').val('');
        $('#edit-combo-discount-amount').val('');
        $('#edit-combo-bonus-qty').val('');
        $('#edit-combo-label').val('');
        $('#edit-combo-sort').val(0);
        $('#edit-combo-active').prop('checked', true);
    });

    // Handle Edit button click
    $(document).on('click', '.btn-edit-combo', function() {
        var btn = $(this);
        $('#edit-combo-id').val(btn.attr('data-id'));
        $('#edit-combo-min-qty').val(btn.attr('data-min-qty'));
        $('#edit-combo-type').val(btn.attr('data-type')).trigger('change');
        $('#edit-combo-discount-percent').val(btn.attr('data-discount-percent'));
        $('#edit-combo-discount-amount').val(btn.attr('data-discount-amount'));
        $('#edit-combo-bonus-qty').val(btn.attr('data-bonus-qty'));
        $('#edit-combo-label').val(btn.attr('data-label'));
        $('#edit-combo-sort').val(btn.attr('data-sort'));
        $('#edit-combo-active').prop('checked', btn.attr('data-active') === "1" || btn.attr('data-active') === "true");
    });

    // Handle Delete button click
    $(document).on('click', '.btn-delete-combo', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-url');
        if (confirm('Bạn có chắc chắn muốn xóa combo này?')) {
            $.ajax({
                url: url,
                type: 'POST',
                data: { _method: 'DELETE', _token: CSRF },
                success: function(res) {
                    if (res.error) {
                        if (typeof Botble !== 'undefined' && Botble.showError) Botble.showError(res.message);
                        else alert(res.message);
                    } else {
                        if (typeof Botble !== 'undefined' && Botble.showSuccess) Botble.showSuccess(res.message);
                        loadCombos();
                    }
                },
                error: function() {
                    if (typeof Botble !== 'undefined' && Botble.showError) Botble.showError('Lỗi xóa combo!');
                    else alert('Lỗi xóa combo!');
                }
            });
        }
    });

    // Save combo via AJAX
    $('#save-combo-btn').on('click', function() {
        var btn = $(this);
        var comboId = $('#edit-combo-id').val();
        var actionUrl = comboId ? UPDATE_URL_BASE.replace('_ID_', comboId) : STORE_URL;
        var originalText = btn.text();
        
        btn.prop('disabled', true).text('Đang lưu...');
        
        var payload = {
            _token: CSRF,
            product_id: $('#edit-combo-product-id').val(),
            min_quantity: $('#edit-combo-min-qty').val(),
            type: $('#edit-combo-type').val(),
            discount_percent: $('#edit-combo-discount-percent').val(),
            discount_amount: $('#edit-combo-discount-amount').val(),
            bonus_qty: $('#edit-combo-bonus-qty').val(),
            label: $('#edit-combo-label').val(),
            sort_order: $('#edit-combo-sort').val(),
            is_active: $('#edit-combo-active').is(':checked') ? 1 : 0
        };
        
        $.ajax({
            type: 'POST', // always POST for Laravel, but _method overrides it to PUT if updating
            url: actionUrl,
            data: payload,
            success: function(res) {
                if (res.error) {
                    if (typeof Botble !== 'undefined' && Botble.showError) Botble.showError(res.message);
                    else alert(res.message);
                } else {
                    if (typeof Botble !== 'undefined' && Botble.showSuccess) Botble.showSuccess(res.message);
                    $('#editComboModal').modal('hide');
                    loadCombos(); // Reload table
                }
            },
            error: function(res) {
                if (typeof Botble !== 'undefined' && Botble.handleError) Botble.handleError(res);
                else alert('Lỗi dữ liệu, vui lòng kiểm tra lại!');
            },
            complete: function() {
                btn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Initialize list
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadCombos);
    } else {
        loadCombos();
    }
})();
</script>

