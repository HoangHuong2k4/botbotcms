<div class="mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold">Lọc trạng thái:</span>
            <select id="filter-sold-status" class="form-select form-select-sm w-auto">
                <option value="all">Tất cả trạng thái</option>
                <option value="1">Đã bán</option>
                <option value="0">Chưa bán</option>
            </select>
            <button type="button" class="btn btn-warning btn-sm d-none" id="btn-bulk-move" data-bs-toggle="modal" data-bs-target="#bulkMoveModal">
                <x-core::icon name="ti ti-arrows-transfer-down" /> Chuyển sản phẩm (<span id="selected-count">0</span>)
            </button>
        </div>
        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#importIframeModal">
            <x-core::icon name="ti ti-upload" /> Import Tài Khoản
        </button>
    </div>
    
    <div class="modal fade" id="importIframeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Tài Khoản hàng loạt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe src="{{ route('telehub.tools.data-synchronize.import.product-items.index', ['popup' => 1]) }}" style="width: 100%; height: 70vh; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <div class="me-auto">
                        <strong class="text-danger">Lưu ý quan trọng:</strong> 
                        File Excel mẫu tải về phải điền đúng <strong>product_id = {{ $product->id }}</strong> để tài khoản được gán vào đúng sản phẩm này nhé!
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.reload();">Đóng & Tải lại</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped table-hover table-bordered table-vcenter" id="product-items-simple-table">
            <thead style="position: sticky; top: 0; background-color: var(--tblr-bg-surface); z-index: 1;">
                <tr>
                    <th style="width: 40px;" class="text-center">
                        <input type="checkbox" class="form-check-input" id="select-all-items">
                    </th>
                    <th style="width: 60px;" class="text-center">ID</th>
                    <th style="width: 20%;">Username</th>
                    <th style="width: 20%;">Password</th>
                    <th>Note</th>
                    <th style="width: 100px;" class="text-center">Trạng thái</th>
                    <th style="width: 150px;">Người mua</th>
                    <th class="text-center" style="width: 120px;">Thao tác</th>
                </tr>
            </thead>
            <tbody id="product-items-tbody">
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mt-3" id="pagination-container" style="display: none !important;">
        <div class="text-muted" id="pagination-info"></div>
        <ul class="pagination m-0" id="pagination-links"></ul>
    </div>
</div>

<x-core::modal id="editItemModal" title="Chỉnh sửa tài khoản" button-id="save-item-btn" button-label="Lưu thay đổi">
    <div id="edit-item-wrapper">
        <input type="hidden" id="edit-item-update-url">
        <div class="mb-3">
            <label class="form-label required">Sản phẩm</label>
            <select name="product_id" id="edit-item-product-id" class="form-select">
                @foreach(\Dev\Telehub\Models\Product::where('tenant_id', $product->tenant_id)->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label required">Username</label>
            <input type="text" name="username" id="edit-item-username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password" id="edit-item-password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Note</label>
            <textarea name="note" id="edit-item-note" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_sold" value="1" id="edit-item-sold">
                <label class="form-check-label" for="edit-item-sold">Đã bán</label>
            </div>
        </div>
    </div>
</x-core::modal>

<template id="icon-edit"><x-core::icon name="ti ti-edit" /></template>
<template id="icon-trash"><x-core::icon name="ti ti-trash" /></template>

<script>
    $(document).ready(function() {
        const iconEdit = $('#icon-edit').html();
        const iconTrash = $('#icon-trash').html();
        
        let currentPage = 1;
        const productId = {{ $product->id }};
        const apiUrl = '{{ route("telehub.product-items.api") }}';

        function loadItems(page = 1) {
            currentPage = page;
            const status = $('#filter-sold-status').val();
            
            $('#product-items-tbody').html('<tr><td colspan="8" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>');
            
            $.ajax({
                url: apiUrl,
                type: 'GET',
                data: {
                    product_id: productId,
                    status: status,
                    page: page,
                    per_page: 20
                },
                success: function(res) {
                    if (res.error) return;
                    
                    const data = res.data;
                    let html = '';
                    
                    if (data.data.length === 0) {
                        html = '<tr><td colspan="8" class="text-center text-muted py-3">Không có dữ liệu</td></tr>';
                    } else {
                        data.data.forEach(item => {
                            const isSoldHtml = item.is_sold 
                                ? '<span class="badge bg-success">Đã bán</span>' 
                                : '<span class="badge bg-warning text-dark">Chưa bán</span>';
                                
                            const customerName = item.customer ? item.customer.full_name : 'N/A';
                            const updateUrl = '{{ route("telehub.product-items.update", ":id") }}'.replace(':id', item.id);
                            const deleteUrl = '{{ route("telehub.product-items.destroy", ":id") }}'.replace(':id', item.id);
                            
                            const usernameSafe = (item.username || '').replace(/"/g, '&quot;');
                            const passwordSafe = (item.password || '').replace(/"/g, '&quot;');
                            const noteSafe = (item.note || '').replace(/"/g, '&quot;');
                            
                            html += `
                            <tr class="product-item-row" data-sold="${item.is_sold ? 1 : 0}">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input item-checkbox" value="${item.id}">
                                </td>
                                <td class="text-center">${item.id}</td>
                                <td><span title="${usernameSafe}">${item.username ? item.username.substring(0, 20) + (item.username.length > 20 ? '...' : '') : ''}</span></td>
                                <td><span title="${passwordSafe}">${item.password ? item.password.substring(0, 20) + (item.password.length > 20 ? '...' : '') : ''}</span></td>
                                <td>${item.note || ''}</td>
                                <td class="text-center">${isSoldHtml}</td>
                                <td>${customerName}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-primary btn-edit-item" 
                                        data-id="${item.id}" 
                                        data-update-url="${updateUrl}"
                                        data-product-id="${item.product_id}"
                                        data-username="${usernameSafe}" 
                                        data-password="${passwordSafe}" 
                                        data-note="${noteSafe}" 
                                        data-sold="${item.is_sold ? 1 : 0}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editItemModal"
                                        title="Edit">
                                        ${iconEdit}
                                    </button>
                                    <a href="#" class="btn btn-sm btn-icon btn-danger deleteDialog" data-section="${deleteUrl}" role="button" title="Delete">
                                        ${iconTrash}
                                    </a>
                                </td>
                            </tr>
                            `;
                        });
                    }
                    
                    $('#product-items-tbody').html(html);
                    $('#select-all-items').prop('checked', false);
                    updateBulkButtonState();
                    
                    renderPagination(data);
                },
                error: function(err) {
                    $('#product-items-tbody').html('<tr><td colspan="8" class="text-center text-danger py-3">Lỗi tải dữ liệu!</td></tr>');
                }
            });
        }
        
        function renderPagination(data) {
            if (data.last_page <= 1) {
                $('#pagination-container').attr('style', 'display: none !important');
                return;
            }
            
            $('#pagination-container').removeAttr('style');
            $('#pagination-info').text(`Hiển thị ${data.from || 0} đến ${data.to || 0} trong tổng ${data.total} bản ghi`);
            
            let links = '';
            
            // Prev
            links += `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${data.current_page - 1}">«</a>
            </li>`;
            
            // Pages
            let start = Math.max(1, data.current_page - 2);
            let end = Math.min(data.last_page, data.current_page + 2);
            
            for (let i = start; i <= end; i++) {
                links += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }
            
            // Next
            links += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${data.current_page + 1}">»</a>
            </li>`;
            
            $('#pagination-links').html(links);
        }
        
        $(document).on('click', '#pagination-links .page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page && page !== currentPage) {
                loadItems(page);
            }
        });

        // Initial Load
        loadItems(1);

        $(document).on('click', '.btn-edit-item', function() {
            var btn = $(this);
            $('#edit-item-update-url').val(btn.attr('data-update-url'));
            $('#edit-item-product-id').val(btn.attr('data-product-id'));
            $('#edit-item-username').val(btn.attr('data-username'));
            $('#edit-item-password').val(btn.attr('data-password'));
            $('#edit-item-note').val(btn.attr('data-note'));
            $('#edit-item-sold').prop('checked', btn.attr('data-sold') == '1');
        });

        $('#save-item-btn').on('click', function() {
            var btn = $(this);
            var actionUrl = $('#edit-item-update-url').val();
            var originalText = btn.text();
            
            btn.prop('disabled', true).text('Đang lưu...');
            
            var payload = {
                _token: '{{ csrf_token() }}',
                product_id: $('#edit-item-product-id').val(),
                username: $('#edit-item-username').val(),
                password: $('#edit-item-password').val(),
                note: $('#edit-item-note').val(),
                is_sold: $('#edit-item-sold').is(':checked') ? 1 : 0
            };
            
            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: payload,
                success: function(res) {
                    if (res.error) {
                        if (typeof Botble !== 'undefined' && Botble.showError) {
                            Botble.showError(res.message);
                        } else if (typeof Apps !== 'undefined' && Apps.showError) {
                            Apps.showError(res.message);
                        } else {
                            alert(res.message);
                        }
                    } else {
                        if (typeof Botble !== 'undefined' && Botble.showSuccess) {
                            Botble.showSuccess(res.message);
                        } else if (typeof Apps !== 'undefined' && Apps.showSuccess) {
                            Apps.showSuccess(res.message);
                        } else {
                            alert(res.message);
                        }
                        
                        $('#editItemModal').modal('hide');
                        loadItems(currentPage);
                    }
                },
                error: function(res) {
                    if (typeof Botble !== 'undefined' && Botble.handleError) {
                        Botble.handleError(res);
                    } else if (typeof Apps !== 'undefined' && Apps.handleError) {
                        Apps.handleError(res);
                    } else {
                        alert('Đã xảy ra lỗi, vui lòng kiểm tra lại dữ liệu!');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).text(originalText);
                }
            });
        });

        $('#filter-sold-status').on('change', function() {
            loadItems(1);
        });

        $('#select-all-items').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.product-item-row:visible').find('.item-checkbox').prop('checked', isChecked);
            updateBulkButtonState();
        });

        $(document).on('change', '.item-checkbox', function() {
            updateBulkButtonState();
        });

        function updateBulkButtonState() {
            var checkedCount = $('.item-checkbox:checked').length;
            $('#selected-count').text(checkedCount);
            $('#bulk-move-count').text(checkedCount);
            
            if (checkedCount > 0) {
                $('#btn-bulk-move').removeClass('d-none');
            } else {
                $('#btn-bulk-move').addClass('d-none');
                $('#select-all-items').prop('checked', false);
            }
        }

        $('#confirm-bulk-move-btn').on('click', function() {
            var btn = $(this);
            var targetProductId = $('#bulk-move-product-id').val();
            if (!targetProductId) {
                alert('Vui lòng chọn sản phẩm đích!');
                return;
            }
            
            var selectedIds = [];
            $('.item-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });
            
            var originalText = btn.text();
            btn.prop('disabled', true).text('Đang chuyển...');
            
            $.ajax({
                type: 'POST',
                url: '{{ route("telehub.product-items.bulk-move") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selectedIds,
                    product_id: targetProductId
                },
                success: function(res) {
                    if (res.error) {
                        if (typeof Botble !== 'undefined' && Botble.showError) {
                            Botble.showError(res.message);
                        } else if (typeof Apps !== 'undefined' && Apps.showError) {
                            Apps.showError(res.message);
                        } else {
                            alert(res.message);
                        }
                    } else {
                        if (typeof Botble !== 'undefined' && Botble.showSuccess) {
                            Botble.showSuccess(res.message);
                        } else if (typeof Apps !== 'undefined' && Apps.showSuccess) {
                            Apps.showSuccess(res.message);
                        } else {
                            alert(res.message);
                        }
                        
                        $('#bulkMoveModal').modal('hide');
                        loadItems(1);
                    }
                },
                error: function(res) {
                    if (typeof Botble !== 'undefined' && Botble.handleError) {
                        Botble.handleError(res);
                    } else if (typeof Apps !== 'undefined' && Apps.handleError) {
                        Apps.handleError(res);
                    } else {
                        alert('Đã xảy ra lỗi, vui lòng kiểm tra lại!');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).text(originalText);
                }
            });
        });
    });
</script>

<x-core::modal id="bulkMoveModal" title="Chuyển sản phẩm hàng loạt" button-id="confirm-bulk-move-btn" button-label="Xác nhận chuyển">
    <div id="bulk-move-wrapper">
        <div class="mb-3">
            <label class="form-label required">Chọn sản phẩm đích</label>
            <select name="product_id" id="bulk-move-product-id" class="form-select">
                @foreach(\Dev\Telehub\Models\Product::where('tenant_id', $product->tenant_id)->where('id', '!=', $product->id)->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <p class="text-muted">Bạn đang chuyển <strong id="bulk-move-count">0</strong> tài khoản đã chọn sang sản phẩm này.</p>
    </div>
</x-core::modal>
