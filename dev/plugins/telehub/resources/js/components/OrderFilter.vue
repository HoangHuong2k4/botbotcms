<script>
import { defineComponent, ref, reactive, onMounted } from 'vue'
import { theme, message } from 'ant-design-vue'

export default defineComponent({
    name: 'OrderFilter',
    props: {
        apiUrl: { type: String, required: true },
        updateUrlPrefix: { type: String, required: true },
        isAdmin: { type: Boolean, default: false },
        initPaymentCode: { type: String, default: '' }
    },
    setup(props) {
        const antTheme = {
            algorithm: theme.darkAlgorithm,
            token: {
                colorPrimary: '#3b82f6',
                borderRadius: 8,
                colorBgContainer: '#1e293b',
                colorBgElevated: '#334155',
                colorBorder: 'rgba(59, 130, 246, 0.3)',
            }
        }

        const filter = reactive({
            code: props.initPaymentCode,
            search: '',
            email: '',
            type: '',
            product_id: null,
            dateRange: []
        })

        const products = ref([])

        const loading = ref(false)
        const orders = ref([])
        const statistics = reactive({
            total_orders: 0,
            total_revenue: 0,
            total_refunded_accs: 0,
            total_refunded_amount: 0
        })
        const pagination = reactive({
            current: 1,
            pageSize: 20,
            total: 0,
            showSizeChanger: true,
            pageSizeOptions: ['10', '20', '50', '100']
        })

        const warrantyModal = reactive({
            visible: false,
            loading: false,
            order: null,
            item: null,
            productName: '',
            duration: 30,
            daysUsed: 0,
            hoursUsed: 0,
            type: 'refund',
            refundAmount: 0,
            note: ''
        })

        const editPriceModal = reactive({
            visible: false,
            loading: false,
            order: null,
            items: [],
            updateBalance: true,
            note: ''
        })

        const columns = [
            { title: 'ID Đơn', dataIndex: 'id', key: 'id', width: 80, sorter: true },
            { title: 'Khách hàng', dataIndex: 'full_name', key: 'customer' },
            { title: 'Mã đơn hàng', dataIndex: 'code', key: 'code', align: 'center' },
            { title: 'Mã nạp (Cũ)', dataIndex: 'payment_code', key: 'payment_code', align: 'center' },
            { title: 'Tổng tiền', dataIndex: 'total_amount', key: 'total_amount', align: 'right', sorter: true },
            { title: 'Trạng thái', dataIndex: 'status', key: 'status', align: 'center', sorter: true },
            { title: 'Loại Đơn', dataIndex: 'type', key: 'type', align: 'center', sorter: true },
            { title: 'Thời gian', dataIndex: 'created_at', key: 'created_at', align: 'right', sorter: true },
            { title: 'Thao tác', key: 'action', align: 'center', width: 190 }
        ]

        const innerColumns = [
            { title: 'Sản phẩm', dataIndex: 'product_name', key: 'product_name' },
            { title: 'Số lượng', dataIndex: 'quantity', key: 'quantity', align: 'center' },
            { title: 'Đơn giá', dataIndex: 'price', key: 'price', align: 'right' },
            { title: 'Thành tiền', key: 'sub_total', align: 'right' },
        ]

        const itemColumns = [
            { title: 'Tài khoản', dataIndex: 'username', key: 'username' },
            { title: 'Mật khẩu', dataIndex: 'password', key: 'password' },
            { title: 'Ghi chú / Status', key: 'note_status' },
            { title: 'Thao tác', key: 'item_action', align: 'center', width: 100 }
        ]

        function fmt(n) {
            return new Intl.NumberFormat('vi-VN').format(n || 0) + '₫'
        }

        async function fetchStats(params) {
            try {
                // Fetch stats from the new stats endpoint
                const statsUrl = props.apiUrl + '/stats?' + params.toString();
                const resp = await fetch(statsUrl, {
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (resp.ok) {
                    const json = await resp.json();
                    statistics.total_orders = json.total_orders || 0;
                    statistics.total_revenue = json.total_revenue || 0;
                    statistics.total_refunded_accs = json.total_refunded_accs || 0;
                    statistics.total_refunded_amount = json.total_refunded_amount || 0;
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function fetchData(page = 1) {
            loading.value = true
            try {
                const params = new URLSearchParams()
                params.set('page', page)
                params.set('per_page', pagination.pageSize)
                if (filter.code) params.set('search', filter.code)
                if (filter.search) params.set('search', filter.search)
                if (filter.email) params.set('email', filter.email)
                if (filter.type) params.set('type', filter.type)
                if (filter.product_id) params.set('product_id', filter.product_id)
                
                if (filter.dateRange && filter.dateRange.length === 2) {
                    params.set('date_from', filter.dateRange[0])
                    params.set('date_to', filter.dateRange[1])
                }
                
                if (pagination.sortField) {
                    params.set('sort_by', pagination.sortField)
                    params.set('sort_dir', pagination.sortOrder === 'ascend' ? 'asc' : 'desc')
                }

                // Call both API and stats
                const respPromise = fetch(props.apiUrl + '?' + params.toString(), {
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                fetchStats(params);

                const resp = await respPromise;
                
                if (!resp.ok) return;

                const json = await resp.json()
                orders.value = json.data || []
                pagination.current = json.current_page
                pagination.pageSize = json.per_page
                pagination.total = json.total
            } finally {
                loading.value = false
            }
        }

        async function changeOrderType(record, newType) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            const hide = message.loading('Đang cập nhật...', 0)
            
            try {
                const resp = await fetch(`${props.updateUrlPrefix}/${record.id}/type`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ type: newType })
                })
                
                const data = await resp.json()
                
                if (resp.ok && !data.error) {
                    message.success('Đã cập nhật loại đơn hàng thành công')
                    record.type = newType
                } else {
                    message.error(data.message || 'Lỗi khi cập nhật')
                }
            } catch (err) {
                message.error('Lỗi kết nối')
            } finally {
                hide()
            }
        }

        function handleTableChange(pag, filters, sorter) {
            pagination.current = pag.current;
            pagination.pageSize = pag.pageSize;
            if (sorter && sorter.field) {
                pagination.sortField = sorter.field;
                pagination.sortOrder = sorter.order;
            } else {
                pagination.sortField = null;
                pagination.sortOrder = null;
            }
            fetchData(pag.current)
        }

        function applyFilter() {
            fetchData(1)
        }

        function checkWarranty(order, itemRecord) {
            const detail = order.details.find(d => d.product_id === itemRecord.product_id)
            const durationDays = detail && detail.duration_days ? detail.duration_days : 0;
            if (!durationDays) return { expired: true, text: 'Không BH' }
            
            const buyDate = new Date(order.created_at)
            const now = new Date()
            const diffHours = Math.floor(Math.abs(now - buyDate) / (1000 * 60 * 60))
            const maxHours = durationDays * 24
            
            if (diffHours >= maxHours) {
                return { expired: true, text: 'Hết hạn BH' }
            }
            return { expired: false, text: 'Còn BH' }
        }

        function openWarrantyModal(order, itemRecord) {
            warrantyModal.order = order
            warrantyModal.item = itemRecord
            
            // Find product details
            const detail = order.details.find(d => d.product_id === itemRecord.product_id)
            warrantyModal.productName = detail ? detail.product_name : 'Sản phẩm'
            warrantyModal.duration = detail && detail.duration_days ? detail.duration_days : 30
            
            // Calculate days used
            const buyDate = new Date(order.created_at)
            const now = new Date()
            const diffTime = Math.abs(now - buyDate)
            const diffHours = Math.floor(diffTime / (1000 * 60 * 60))
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24))
            
            warrantyModal.daysUsed = diffDays
            warrantyModal.hoursUsed = diffHours
            warrantyModal.type = 'refund'
            
            const price = detail ? detail.price : 0
            
            if (warrantyModal.duration === 1) {
                // 24h logic
                const remainingHours = Math.max(0, 24 - diffHours)
                warrantyModal.refundAmount = Math.floor((price / 24) * remainingHours)
                warrantyModal.note = `Lỗi tài khoản sau ${diffHours} giờ sử dụng.`
            } else {
                // > 1 day logic
                const remainingDays = Math.max(0, warrantyModal.duration - diffDays)
                warrantyModal.refundAmount = Math.floor((price / warrantyModal.duration) * remainingDays)
                warrantyModal.note = `Lỗi tài khoản sau ${diffDays} ngày sử dụng.`
            }
            
            warrantyModal.visible = true
        }

        async function submitWarranty() {
            if (warrantyModal.type === 'refund' && warrantyModal.refundAmount < 0) {
                message.error('Số tiền hoàn không hợp lệ')
                return
            }
            
            warrantyModal.loading = true
            try {
                const hide = message.loading('Đang xử lý...', 0)
                const resp = await fetch(`${props.updateUrlPrefix}/${warrantyModal.order.id}/warranty`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_item_id: warrantyModal.item.id,
                        type: warrantyModal.type,
                        refund_amount: warrantyModal.refundAmount,
                        days_used: warrantyModal.daysUsed,
                        note: warrantyModal.note
                    })
                })
                hide()
                const data = await resp.json()
                if (resp.ok && !data.error) {
                    message.success(data.message || 'Xử lý thành công')
                    warrantyModal.visible = false
                    fetchData(pagination.current)
                } else {
                    message.error(data.message || 'Có lỗi xảy ra')
                }
            } catch (err) {
                message.error('Lỗi kết nối')
            } finally {
                warrantyModal.loading = false
            }
        }

        function resetFilter() {
            filter.code = ''
            filter.search = ''
            filter.email = ''
            filter.type = ''
            filter.product_id = null
            filter.dateRange = []
            pagination.current = 1
            fetchData(1)
        }

        function formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr)
            return d.toLocaleString('vi-VN')
        }

        async function loadProducts() {
            try {
                const url = props.apiUrl.replace('/api', '/api/products')
                const resp = await fetch(url, {
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                if (resp.ok) {
                    products.value = await resp.json()
                }
            } catch (err) {
                console.error('Failed to load products', err)
            }
        }

        function openEditPriceModal(record) {
            editPriceModal.order = record
            editPriceModal.items = (record.details || []).map(d => ({
                id: d.id,
                product_name: d.product_name,
                quantity: d.quantity,
                price: Number(d.price) || 0,
            }))
            editPriceModal.updateBalance = true
            editPriceModal.note = ''
            editPriceModal.visible = true
        }

        function getEditPriceNewTotal() {
            return editPriceModal.items.reduce((sum, item) => sum + (Number(item.price) || 0) * (Number(item.quantity) || 1), 0)
        }

        function getEditPriceDiff() {
            if (!editPriceModal.order) return 0
            const oldTotal = Number(editPriceModal.order.total_amount) || 0
            return oldTotal - getEditPriceNewTotal()
        }

        async function submitEditPrice() {
            if (!editPriceModal.order) return
            editPriceModal.loading = true
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            const hide = message.loading('Đang lưu thay đổi giá...', 0)

            try {
                const resp = await fetch(`${props.updateUrlPrefix}/${editPriceModal.order.id}/price`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        items: editPriceModal.items.map(i => ({ id: i.id, price: i.price })),
                        update_balance: editPriceModal.updateBalance,
                        note: editPriceModal.note
                    })
                })

                const data = await resp.json()

                if (resp.ok && !data.error) {
                    message.success(data.message || 'Cập nhật giá đơn hàng thành công')
                    const index = orders.value.findIndex(o => o.id === editPriceModal.order.id)
                    if (index !== -1 && data.order) {
                        orders.value[index] = { ...orders.value[index], ...data.order }
                    }
                    editPriceModal.visible = false
                    fetchData(pagination.current)
                } else {
                    message.error(data.message || 'Lỗi khi cập nhật giá')
                }
            } catch (err) {
                message.error('Lỗi kết nối khi cập nhật giá')
            } finally {
                hide()
                editPriceModal.loading = false
            }
        }

        onMounted(() => {
            loadProducts()
            fetchData(1)
        })

        return {
            antTheme, filter, loading, orders, statistics, pagination, products,
            columns, innerColumns, itemColumns, fmt, formatDate,
            applyFilter, resetFilter, handleTableChange, changeOrderType,
            warrantyModal,
            openWarrantyModal,
            submitWarranty,
            checkWarranty,
            editPriceModal,
            openEditPriceModal,
            getEditPriceNewTotal,
            getEditPriceDiff,
            submitEditPrice
        }
    }
})
</script>

<template>
<a-config-provider :theme="antTheme">
    <div style="padding: 10px;">
        <a-card style="margin-bottom: 24px; border-radius: 12px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <span style="font-size:13px; font-weight:700; color:rgba(147,197,253,.8); text-transform: uppercase;">
                    <i class="ti ti-search me-1"></i> Tra cứu đơn hàng
                </span>
            </div>
            
            <a-row :gutter="[16, 16]">
                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Mã đơn hàng (Order Code)</div>
                    <a-input 
                        v-model:value="filter.code" 
                        placeholder="Nhập mã đơn hàng..." 
                        allow-clear
                        @pressEnter="applyFilter"
                    />
                </a-col>
                
                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Tìm kiếm khách hàng (Tên / ID)</div>
                    <a-input 
                        v-model:value="filter.search" 
                        placeholder="Nhập Tên, Telegram ID hoặc ID đơn hàng..." 
                        allow-clear
                        @pressEnter="applyFilter"
                    />
                </a-col>

                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Email / Tài khoản đã mua</div>
                    <a-input 
                        v-model:value="filter.email" 
                        placeholder="Nhập email hoặc tài khoản để tìm..." 
                        allow-clear
                        @pressEnter="applyFilter"
                    />
                </a-col>
                
                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Lọc theo Thời gian</div>
                    <a-range-picker 
                        v-model:value="filter.dateRange" 
                        value-format="YYYY-MM-DD"
                        style="width: 100%"
                        @change="applyFilter"
                    />
                </a-col>
                
                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Loại đơn hàng</div>
                    <a-select v-model:value="filter.type" style="width: 100%" placeholder="Tất cả" allow-clear @change="applyFilter">
                        <a-select-option value="">Tất cả</a-select-option>
                        <a-select-option value="sale">Đơn mua hàng (Sale)</a-select-option>
                        <a-select-option value="warranty">Bảo hành (Warranty)</a-select-option>
                        <a-select-option value="login">Login (Chuyển khoản tay)</a-select-option>
                    </a-select>
                </a-col>

                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Lọc theo Sản phẩm</div>
                    <a-select
                        v-model:value="filter.product_id"
                        style="width: 100%"
                        placeholder="Tất cả sản phẩm"
                        allow-clear
                        show-search
                        :filter-option="(input, option) => option.label.toLowerCase().includes(input.toLowerCase())"
                        @change="applyFilter"
                    >
                        <a-select-option :value="null" label="Tất cả sản phẩm">Tất cả sản phẩm</a-select-option>
                        <a-select-option
                            v-for="p in products"
                            :key="p.id"
                            :value="p.id"
                            :label="p.name"
                        >{{ p.name }}</a-select-option>
                    </a-select>
                </a-col>
            </a-row>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 8px;">
                <a-button @click="resetFilter">Xoá lọc</a-button>
                <a-button type="primary" @click="applyFilter" :loading="loading">Tìm Kiếm</a-button>
            </div>
            
            <div style="margin-top: 24px; padding: 16px; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px dashed rgba(59, 130, 246, 0.3); display: flex; flex-wrap: wrap; gap: 32px; align-items: center;">
                <div>
                    <div style="font-size: 13px; color: #94a3b8; margin-bottom: 4px;">Tổng số đơn hàng</div>
                    <div style="font-size: 20px; font-weight: bold; color: #3b82f6;">{{ statistics.total_orders }} <span style="font-size: 14px; font-weight: normal; color: #94a3b8;">đơn</span></div>
                </div>
                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                <div>
                    <div style="font-size: 13px; color: #94a3b8; margin-bottom: 4px;">Tổng doanh thu (Đã trừ hoàn)</div>
                    <div style="font-size: 20px; font-weight: bold; color: #10b981;">{{ fmt(statistics.total_revenue) }}</div>
                </div>
                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                <div>
                    <div style="font-size: 13px; color: #94a3b8; margin-bottom: 4px;">Tài khoản đã thu hồi (Hoàn tiền)</div>
                    <div style="font-size: 20px; font-weight: bold; color: #ef4444;">{{ statistics.total_refunded_accs }} <span style="font-size: 14px; font-weight: normal; color: #94a3b8;">acc</span></div>
                </div>
                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                <div>
                    <div style="font-size: 13px; color: #94a3b8; margin-bottom: 4px;">Tổng tiền đã hoàn (Thu hồi)</div>
                    <div style="font-size: 20px; font-weight: bold; color: #ef4444;">{{ fmt(statistics.total_refunded_amount) }}</div>
                </div>
            </div>
        </a-card>

        <a-card title="Danh sách đơn hàng" style="border-radius: 12px;" :bodyStyle="{padding: 0}">
            <a-table 
                :dataSource="orders" 
                :columns="columns" 
                :pagination="pagination"
                :loading="loading"
                @change="handleTableChange"
                rowKey="id"
                expandRowByClick
            >
                <template #bodyCell="{ column, record }">
                    <template v-if="column.key === 'id'">
                        #{{ record.id }}
                    </template>
                    <template v-if="column.key === 'customer'">
                        <div style="font-weight:700;">{{ record.full_name || 'Khách' }}</div>
                        <div style="font-size:12px; opacity:0.6;"><i class="ti ti-brand-telegram"></i> {{ record.telegram_id }}</div>
                    </template>
                    <template v-if="column.key === 'code'">
                        <span style="font-family: monospace; font-weight: bold; color: #facc15;">{{ record.code || '-' }}</span>
                    </template>
                    <template v-if="column.key === 'payment_code'">
                        <span style="font-family: monospace; font-size: 11px; color: #94a3b8;">{{ record.payment_code || '-' }}</span>
                    </template>
                    <template v-if="column.key === 'total_amount'">
                        <div v-if="record.refunded_amount > 0">
                            <span style="text-decoration: line-through; color: #64748b; font-size: 12px; margin-right: 4px;">{{ fmt(record.total_amount) }}</span>
                            <span style="color: #10b981; font-weight: 600;">{{ fmt(record.total_amount - record.refunded_amount) }}</span>
                            <div style="font-size: 11px; color: #ef4444; margin-top: 2px;">
                                <i class="ti ti-arrow-back-up"></i> Đã hoàn {{ fmt(record.refunded_amount) }}
                            </div>
                        </div>
                        <span v-else style="color: #10b981; font-weight: 600;">{{ fmt(record.total_amount) }}</span>
                    </template>
                    <template v-if="column.key === 'status'">
                        <a-tag :color="record.status === 'completed' ? 'success' : 'default'">{{ record.status }}</a-tag>
                    </template>
                    <template v-if="column.key === 'type'">
                        <a-tag v-if="record.type === 'warranty'" color="error">Bảo hành / Lỗi</a-tag>
                        <a-tag v-else-if="record.type === 'login'" color="purple">Login (CK tay)</a-tag>
                        <a-tag v-else color="blue">Bán ra</a-tag>
                    </template>
                    <template v-if="column.key === 'created_at'">
                        {{ formatDate(record.created_at) }}
                    </template>
                    <template v-if="column.key === 'action'">
                        <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                            <a-button type="primary" ghost size="small" @click.stop="openEditPriceModal(record)" title="Chỉnh sửa giá đơn hàng">
                                <i class="ti ti-edit"></i> Sửa giá
                            </a-button>

                            <a-dropdown :trigger="['click']">
                                <a-button type="dashed" size="small">
                                    Đổi Loại <i class="ti ti-chevron-down ms-1"></i>
                                </a-button>
                                <template #overlay>
                                    <a-menu>
                                        <a-menu-item @click="changeOrderType(record, 'sale')" :disabled="record.type === 'sale'">
                                            Đánh dấu là Bán ra
                                        </a-menu-item>
                                        <a-menu-item @click="changeOrderType(record, 'login')" :disabled="record.type === 'login'" style="color: #a855f7;">
                                            Đánh dấu là Login (CK tay)
                                        </a-menu-item>
                                        <a-menu-item @click="changeOrderType(record, 'warranty')" :disabled="record.type === 'warranty'" style="color: #ef4444;">
                                            Đánh dấu Bảo hành / Lỗi
                                        </a-menu-item>
                                    </a-menu>
                                </template>
                            </a-dropdown>
                        </div>
                    </template>
                </template>

                <template #expandedRowRender="{ record }">
                    <div style="padding: 16px; background-color: rgba(255, 255, 255, 0.03); border-radius: 8px;">
                        <h4 style="color:#93c5fd; margin-bottom: 16px;"><i class="ti ti-box"></i> Sản phẩm trong đơn</h4>
                        <a-table 
                            :dataSource="record.details" 
                            :columns="innerColumns" 
                            :pagination="false"
                            size="small"
                            rowKey="id"
                            bordered
                            style="margin-bottom: 24px;"
                        >
                            <template #bodyCell="{ column, record: innerRecord }">
                                <template v-if="column.key === 'price'">
                                    <div v-if="innerRecord.price_usd" style="line-height:1.4;">
                                        <div style="color:#f59e0b; font-weight:600;">
                                            ${{ innerRecord.price_usd }}/acc
                                        </div>
                                        <div style="color:#64748b; font-size:11px;">
                                            &asymp; {{ fmt(innerRecord.price) }}/acc
                                        </div>
                                    </div>
                                    <span v-else>{{ fmt(innerRecord.price) }}</span>
                                </template>
                                <template v-if="column.key === 'sub_total'">
                                    <span style="color: #10b981; font-weight: bold;">{{ record.details.length === 1 ? fmt(record.total_amount) : fmt(innerRecord.price * innerRecord.quantity) }}</span>
                                </template>
                            </template>
                        </a-table>

                        <h4 style="color:#93c5fd; margin-bottom: 16px;"><i class="ti ti-key"></i> Tài khoản đã giao</h4>
                        <a-table 
                            v-if="record.items && record.items.length"
                            :dataSource="record.items" 
                            :columns="itemColumns" 
                            :pagination="false"
                            size="small"
                            rowKey="id"
                            bordered
                        >
                            <template #bodyCell="{ column, record: itemRecord }">
                                <template v-if="column.key === 'username'">
                                    <div style="font-family: monospace; word-break: break-all;">{{ itemRecord.username || '-' }}</div>
                                </template>
                                <template v-if="column.key === 'password'">
                                    <div style="font-family: monospace; word-break: break-all;">{{ itemRecord.password || '-' }}</div>
                                </template>
                                <template v-if="column.key === 'note_status'">
                                    <div>{{ itemRecord.note || '-' }}</div>
                                    <a-tag v-if="itemRecord.status === 'revoked'" color="error" style="margin-top: 4px;">Đã thu hồi</a-tag>
                                    <a-tag v-else-if="itemRecord.status === 'replaced'" color="warning" style="margin-top: 4px;">Đã đổi trả</a-tag>
                                    <a-tag v-else color="success" style="margin-top: 4px;">Active</a-tag>
                                </template>
                                <template v-if="column.key === 'item_action'">
                                    <template v-if="itemRecord.status === 'active'">
                                        <a-button 
                                            v-if="!checkWarranty(record, itemRecord).expired"
                                            type="primary" 
                                            danger 
                                            size="small" 
                                            @click="openWarrantyModal(record, itemRecord)">
                                            Bảo Hành
                                        </a-button>
                                        <a-tag v-else color="default" style="margin: 0;">{{ checkWarranty(record, itemRecord).text }}</a-tag>
                                    </template>
                                </template>
                            </template>
                        </a-table>
                        <div v-else style="color: rgba(255,255,255,0.5); font-style: italic;">Không có tài khoản nào được giao.</div>
                    </div>
                </template>
            </a-table>
        </a-card>
        <a-modal
            v-model:visible="warrantyModal.visible"
            title="Xử lý Bảo Hành / Hoàn Tiền"
            @ok="submitWarranty"
            :confirmLoading="warrantyModal.loading"
        >
            <div style="margin-bottom: 16px;">
                <p><strong>Khách hàng:</strong> {{ warrantyModal.order?.full_name }}</p>
                <p><strong>Tài khoản:</strong> <span style="font-family: monospace;">{{ warrantyModal.item?.username }}</span></p>
                <p><strong>Sản phẩm:</strong> {{ warrantyModal.productName }} (Gói {{ warrantyModal.duration === 1 ? '24h' : warrantyModal.duration + ' ngày' }})</p>
                <p><strong>Đã dùng:</strong> {{ warrantyModal.duration === 1 ? warrantyModal.hoursUsed + ' giờ' : warrantyModal.daysUsed + ' ngày' }}</p>
            </div>
            
            <a-form layout="vertical">
                <a-form-item label="Hình thức">
                    <a-radio-group v-model:value="warrantyModal.type">
                        <a-radio value="refund">Hoàn tiền</a-radio>
                        <a-radio value="replace">Đổi trả (Không hoàn tiền)</a-radio>
                    </a-radio-group>
                </a-form-item>
                
                <a-form-item label="Số tiền hoàn lại (VNĐ)" v-if="warrantyModal.type === 'refund'">
                    <a-input-number 
                        v-model:value="warrantyModal.refundAmount" 
                        style="width: 100%" 
                        :min="0"
                        :formatter="value => `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                    />
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;" v-if="warrantyModal.duration === 1">
                        Gợi ý: (Giá bán / 24) x {{ Math.max(0, 24 - warrantyModal.hoursUsed) }} giờ còn lại
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;" v-else>
                        Gợi ý: (Giá bán / {{ warrantyModal.duration }}) x {{ Math.max(0, warrantyModal.duration - warrantyModal.daysUsed) }} ngày còn lại
                    </div>
                </a-form-item>

                <a-form-item label="Ghi chú (Lý do)">
                    <a-textarea v-model:value="warrantyModal.note" :rows="3" placeholder="Nhập lý do bảo hành..."></a-textarea>
                </a-form-item>
            </a-form>
        </a-modal>

        <!-- Modal Chỉnh sửa giá đơn hàng -->
        <a-modal
            v-model:visible="editPriceModal.visible"
            :title="'Chỉnh sửa giá đơn hàng #' + (editPriceModal.order ? (editPriceModal.order.code || editPriceModal.order.id) : '')"
            @ok="submitEditPrice"
            :confirmLoading="editPriceModal.loading"
            okText="Lưu thay đổi"
            cancelText="Hủy"
            width="650px"
        >
            <div v-if="editPriceModal.order" style="padding-top: 10px;">
                <div style="background: rgba(255,255,255,0.04); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: #94a3b8; font-size: 12px;">Khách hàng</div>
                        <div style="font-weight: 700; color: #fff;">{{ editPriceModal.order.full_name || 'Khách' }} <span style="font-weight: normal; opacity: 0.7;">({{ editPriceModal.order.telegram_id }})</span></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: #94a3b8; font-size: 12px;">Tổng tiền ban đầu</div>
                        <div style="font-weight: 700; color: #facc15; font-size: 15px;">{{ fmt(editPriceModal.order.total_amount) }}</div>
                    </div>
                </div>

                <div style="color: #bfdbfe; font-size: 13px; font-weight: 600; margin-bottom: 8px;">
                    <i class="ti ti-list"></i> Danh sách sản phẩm & đơn giá:
                </div>

                <div style="border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; overflow: hidden; margin-bottom: 16px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="background: rgba(255,255,255,0.06); color: #94a3b8; text-align: left;">
                                <th style="padding: 10px 12px;">Sản phẩm</th>
                                <th style="padding: 10px 12px; text-align: center; width: 80px;">SL</th>
                                <th style="padding: 10px 12px; width: 170px;">Đơn giá mới (VNĐ)</th>
                                <th style="padding: 10px 12px; text-align: right; width: 130px;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in editPriceModal.items" :key="item.id" style="border-top: 1px solid rgba(255,255,255,0.06);">
                                <td style="padding: 10px 12px; font-weight: 500;">{{ item.product_name }}</td>
                                <td style="padding: 10px 12px; text-align: center;">{{ item.quantity }}</td>
                                <td style="padding: 10px 12px;">
                                    <a-input-number
                                        v-model:value="item.price"
                                        :min="0"
                                        :step="1000"
                                        :formatter="value => `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                                        style="width: 100%; font-weight: 600;"
                                    />
                                </td>
                                <td style="padding: 10px 12px; text-align: right; font-weight: 600; color: #10b981;">
                                    {{ fmt((item.price || 0) * (item.quantity || 1)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="background: rgba(59, 130, 246, 0.08); border: 1px dashed rgba(59, 130, 246, 0.4); border-radius: 8px; padding: 12px 16px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="color: #94a3b8; font-size: 13px;">Tổng tiền sau điều chỉnh:</span>
                        <span style="font-size: 18px; font-weight: 700; color: #10b981;">{{ fmt(getEditPriceNewTotal()) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                        <span style="color: #94a3b8;">Chênh lệch:</span>
                        <span v-if="getEditPriceDiff() > 0" style="color: #34d399; font-weight: 600;">
                            Giảm {{ fmt(getEditPriceDiff()) }} (Hoàn tiền vào ví)
                        </span>
                        <span v-else-if="getEditPriceDiff() < 0" style="color: #f87171; font-weight: 600;">
                            Tăng {{ fmt(Math.abs(getEditPriceDiff())) }} (Trừ tiền ví)
                        </span>
                        <span v-else style="color: #94a3b8;">
                            Không thay đổi (0₫)
                        </span>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <a-checkbox v-model:checked="editPriceModal.updateBalance" style="color: #cbd5e1;">
                        Tự động cập nhật số dư ví khách hàng (Cộng tiền hoàn nếu giảm giá, trừ thêm nếu tăng giá)
                    </a-checkbox>
                </div>

                <div>
                    <div style="color: #94a3b8; font-size: 12px; margin-bottom: 6px;">Ghi chú điều chỉnh (tùy chọn):</div>
                    <a-input v-model:value="editPriceModal.note" placeholder="VD: Thỏa thuận giá đại lý, giảm giá khách quen..." />
                </div>
            </div>
        </a-modal>
    </div>
</a-config-provider>
</template>
