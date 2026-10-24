<script>
import { defineComponent, ref, reactive, onMounted } from 'vue'
import { theme, message, Modal } from 'ant-design-vue'

export default defineComponent({
    name: 'DealerManager',
    props: {
        apiUrl: { type: String, required: true },
        updateUrlPrefix: { type: String, required: true },
        searchCustomersUrl: { type: String, required: true },
        isAdmin: { type: Boolean, default: false }
    },
    setup(props) {
        const antTheme = {
            algorithm: theme.darkAlgorithm,
            token: {
                colorPrimary: '#8b5cf6', // Violet theme for Dealers
                borderRadius: 8,
                colorBgContainer: '#1e293b',
                colorBgElevated: '#334155',
                colorBorder: 'rgba(139, 92, 246, 0.3)',
            }
        }
        
        const loading = ref(false)
        const dealers = ref([])

        const filter = reactive({
            search: ''
        })

        const pagination = reactive({
            current: 1,
            pageSize: 20,
            total: 0
        })

        const priceModal = reactive({
            visible: false,
            loading: false,
            dealer: null,
            prices: []
        })
        const addModal = reactive({
            visible: false,
            loading: false,
            search: '',
            customers: []
        })

        const columns = [
            { title: 'Tên CTV', dataIndex: 'full_name', key: 'name' },
            { title: 'Telegram ID', dataIndex: 'telegram_id', key: 'telegram_id' },
            { title: 'API Key', dataIndex: 'api_key', key: 'api_key', width: 250 },
            { title: 'Trạng thái', dataIndex: 'is_dealer', key: 'status', align: 'center' },
            { title: 'Tổng Đơn', dataIndex: 'orders_count', key: 'orders_count', align: 'center' },
            { title: 'Doanh thu', dataIndex: 'orders_sum_total_amount', key: 'revenue', align: 'right' },
            { title: 'Thao tác', key: 'action', align: 'center', width: 200 }
        ]

        const priceColumns = [
            { title: 'Sản phẩm', dataIndex: 'name', key: 'name' },
            { title: 'Giá gốc (₫)', dataIndex: 'retail_price', key: 'retail_price', align: 'right', width: 110 },
            { title: 'Giá Sỉ CTV (₫)', key: 'dealer_price', align: 'center', width: 140 },
            { title: 'Giá gốc ($)', dataIndex: 'retail_price_usd', key: 'retail_price_usd', align: 'right', width: 110 },
            { title: 'Giá Sỉ CTV ($)', key: 'dealer_price_usd', align: 'center', width: 140 }
        ]

        const innerColumns = [
            { title: 'Tên sản phẩm', dataIndex: 'product_name', key: 'product_name' },
            { title: 'Số lượng mua', dataIndex: 'total_qty', key: 'total_qty', align: 'center' },
            { title: 'Thành tiền', dataIndex: 'sub_total', key: 'sub_total', align: 'right' }
        ]

        const topDealers = ref([])
        const topProducts = ref([])
        const purchasesMap = reactive({})

        function fmt(n) {
            return new Intl.NumberFormat('vi-VN').format(n || 0) + '₫'
        }

        async function fetchDealers(page = 1) {
            loading.value = true
            try {
                const params = new URLSearchParams()
                params.set('page', page)
                if (filter.search) params.set('search', filter.search)

                const resp = await fetch(props.apiUrl + '?' + params.toString(), {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                const text = await resp.text()
                let json;
                try {
                    json = JSON.parse(text)
                } catch (e) {
                    const cleanText = text.substring(0, text.lastIndexOf('}') + 1)
                    json = JSON.parse(cleanText)
                }
                
                dealers.value = json.data || []
                pagination.current = json.current_page
                pagination.pageSize = json.per_page
                pagination.total = json.total
            } catch (err) {
                console.error('Fetch error:', err)
                message.error('Lỗi tải dữ liệu: ' + err.message)
            } finally {
                loading.value = false
            }
        }

        async function fetchStats() {
            try {
                const resp = await fetch(props.updateUrlPrefix + '/api/stats', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                const text = await resp.text()
                let json;
                try {
                    json = JSON.parse(text)
                } catch (e) {
                    const cleanText = text.substring(0, text.lastIndexOf('}') + 1)
                    json = JSON.parse(cleanText)
                }
                if (json.success) {
                    topDealers.value = json.top_dealers || []
                    topProducts.value = json.top_products || []
                }
            } catch (err) {
                console.error('Fetch stats error:', err)
            }
        }

        async function fetchPurchases(expanded, record) {
            if (expanded && !purchasesMap[record.id]) {
                purchasesMap[record.id] = { loading: true, data: [] }
                try {
                    const resp = await fetch(`${props.updateUrlPrefix}/${record.id}/purchases`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    const text = await resp.text()
                    let json;
                    try {
                        json = JSON.parse(text)
                    } catch (e) {
                        const cleanText = text.substring(0, text.lastIndexOf('}') + 1)
                        json = JSON.parse(cleanText)
                    }
                    if (json.success) {
                        purchasesMap[record.id].data = json.data
                    }
                } catch (err) {
                    console.error('Fetch purchases error:', err)
                } finally {
                    purchasesMap[record.id].loading = false
                }
            }
        }

        function handleTableChange(pag) {
            fetchDealers(pag.current)
        }

        function applyFilter() {
            fetchDealers(1)
        }

        function resetFilter() {
            filter.search = ''
            fetchDealers(1)
        }

        async function copyKey(key) {
            if (!key) return;
            try {
                await navigator.clipboard.writeText(key);
                message.success('Đã copy API Key!');
            } catch (err) {
                message.error('Copy thất bại.');
            }
        }

        async function generateKey(dealer) {
            Modal.confirm({
                title: 'Cấp lại API Key?',
                content: 'Key cũ sẽ bị vô hiệu hóa. CTV phải cập nhật Key mới vào tool của họ.',
                okText: 'Tạo mới',
                okType: 'danger',
                cancelText: 'Hủy',
                async onOk() {
                    const hide = message.loading('Đang xử lý...', 0)
                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        const resp = await fetch(`${props.updateUrlPrefix}/${dealer.id}/api-key`, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
                        })
                        const data = await resp.json()
                        if (data.success) {
                            message.success('Đã cấp API Key mới')
                            dealer.api_key = data.api_key
                        }
                    } finally {
                        hide()
                    }
                }
            })
        }

        async function toggleDealer(dealer, status) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            const hide = message.loading('Đang xử lý...', 0)
            try {
                const resp = await fetch(`${props.updateUrlPrefix}/${dealer.id}/toggle`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ is_dealer: status })
                })
                const data = await resp.json()
                if (data.success) {
                    message.success('Đã cập nhật trạng thái CTV')
                    fetchDealers()
                }
            } finally {
                hide()
            }
        }

        async function openPriceModal(dealer) {
            priceModal.dealer = dealer
            priceModal.visible = true
            priceModal.loading = true
            priceModal.prices = []
            
            try {
                const resp = await fetch(`${props.updateUrlPrefix}/${dealer.id}/prices`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                const text = await resp.text()
                let json;
                try {
                    json = JSON.parse(text)
                } catch (e) {
                    const cleanText = text.substring(0, text.lastIndexOf('}') + 1)
                    json = JSON.parse(cleanText)
                }
                if (json.success) {
                    priceModal.prices = json.data
                }
            } catch (err) {
                message.error('Lỗi tải bảng giá: ' + err.message)
            } finally {
                priceModal.loading = false
            }
        }

        async function savePrice(product) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            try {
                const resp = await fetch(`${props.updateUrlPrefix}/${priceModal.dealer.id}/prices`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ 
                        product_id: product.product_id, 
                        price: product.dealer_price,
                        price_usd: product.dealer_price_usd 
                    })
                })
                const data = await resp.json()
                if (data.success) {
                    message.success('Đã lưu giá sỉ cho sản phẩm này')
                }
            } catch (err) {
                message.error('Lỗi lưu giá')
            }
        }
        
        async function openAddModal() {
            addModal.visible = true
            addModal.search = ''
            addModal.customers = []
            searchCustomers()
        }

        async function searchCustomers() {
            addModal.loading = true
            try {
                const resp = await fetch(`${props.searchCustomersUrl}?q=${addModal.search}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                const text = await resp.text()
                let json;
                try {
                    json = JSON.parse(text)
                } catch (e) {
                    const cleanText = text.substring(0, text.lastIndexOf('}') + 1)
                    json = JSON.parse(cleanText)
                }
                if (json.success) addModal.customers = json.data
            } catch (err) {
                message.error('Lỗi tìm kiếm: ' + err.message)
            } finally {
                addModal.loading = false
            }
        }

        async function clearAllPricesConfirm() {
            Modal.confirm({
                title: 'Clear toàn bộ giá sỉ?',
                content: 'Hành động này sẽ xoá tất cả giá sỉ đã cài đặt cho TẤT CẢ CTV, đưa về giá gốc mặc định. Bạn có chắc chắn muốn tiếp tục?',
                okText: 'Xoá tất cả',
                okType: 'danger',
                cancelText: 'Hủy',
                async onOk() {
                    const hide = message.loading('Đang xử lý...', 0)
                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        const resp = await fetch(`${props.updateUrlPrefix}/clear-all-prices`, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
                        })
                        const data = await resp.json()
                        if (data.success) {
                            message.success('Đã clear toàn bộ giá sỉ thành công!')
                        } else {
                            message.error('Có lỗi xảy ra!')
                        }
                    } catch(e) {
                        message.error('Lỗi khi xoá: ' + e.message)
                    } finally {
                        hide()
                    }
                }
            })
        }

        onMounted(() => {
            fetchDealers(1)
            fetchStats()
        })

        return {
            antTheme, loading, dealers, columns, priceColumns, innerColumns, fmt,
            filter, pagination, handleTableChange, applyFilter, resetFilter,
            priceModal, addModal, topDealers, topProducts, purchasesMap,
            fetchDealers, fetchStats, fetchPurchases, copyKey, generateKey, toggleDealer, openPriceModal, savePrice,
            openAddModal, searchCustomers, clearAllPricesConfirm
        }
    }
})
</script>

<template>
<a-config-provider :theme="antTheme">
    <div style="padding: 10px;">
        <a-card style="margin-bottom: 24px; border-radius: 12px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); border: 1px solid rgba(139, 92, 246, 0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h2 style="color: #c4b5fd; margin: 0;"><i class="ti ti-users"></i> Quản lý Cộng Tác Viên (API)</h2>
                    <p style="color: #94a3b8; font-size: 13px; margin-top: 4px;">Cấp API Key và cài đặt giá sỉ riêng cho từng đối tác mua hàng tự động qua API.</p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a-button danger @click="clearAllPricesConfirm">
                        <i class="ti ti-trash me-1"></i> Clear tất cả giá sỉ
                    </a-button>
                    <a-button type="primary" style="background: #8b5cf6; border: none;" @click="openAddModal">
                        <i class="ti ti-plus me-1"></i> Thêm CTV mới
                    </a-button>
                </div>
            </div>

            <!-- DASHBOARD TOP STATS -->
            <a-row :gutter="[16, 16]" style="margin-bottom: 24px;">
                <a-col :xs="24" :lg="12">
                    <a-card title="🏆 Top Cộng Tác Viên" style="border-radius: 12px; background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.2);" :bodyStyle="{padding: 0}">
                        <a-table 
                            :dataSource="topDealers" 
                            :columns="[
                                { title: 'Tên CTV', dataIndex: 'full_name', key: 'name' },
                                { title: 'Tổng Đơn', dataIndex: 'orders_count', key: 'orders_count', align: 'center' },
                                { title: 'Doanh thu', dataIndex: 'orders_sum_total_amount', key: 'revenue', align: 'right' }
                            ]" 
                            size="small" 
                            :pagination="false"
                            rowKey="id"
                        >
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'name'">
                                    <div style="font-weight:600; color:#c4b5fd;">{{ record.full_name || 'Khách' }}</div>
                                </template>
                                <template v-if="column.key === 'revenue'">
                                    <span style="color: #10b981; font-weight: bold;">{{ fmt(record.orders_sum_total_amount) }}</span>
                                </template>
                            </template>
                        </a-table>
                    </a-card>
                </a-col>
                <a-col :xs="24" :lg="12">
                    <a-card title="🔥 Top Sản Phẩm Bán Qua CTV" style="border-radius: 12px; background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.2);" :bodyStyle="{padding: 0}">
                        <a-table 
                            :dataSource="topProducts" 
                            :columns="[
                                { title: 'Sản phẩm', dataIndex: 'product_name', key: 'name' },
                                { title: 'Lượt mua', dataIndex: 'total_qty', key: 'qty', align: 'center' },
                                { title: 'Doanh thu', dataIndex: 'total_revenue', key: 'revenue', align: 'right' }
                            ]" 
                            size="small" 
                            :pagination="false"
                            rowKey="product_id"
                        >
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'revenue'">
                                    <span style="color: #10b981; font-weight: bold;">{{ fmt(record.total_revenue) }}</span>
                                </template>
                            </template>
                        </a-table>
                    </a-card>
                </a-col>
            </a-row>

            <a-row :gutter="[16, 16]">
                <a-col :xs="24" :md="8">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Tìm kiếm CTV (Tên / ID / API Key)</div>
                    <a-input 
                        v-model:value="filter.search" 
                        placeholder="Nhập Tên, Telegram ID hoặc API Key..." 
                        allow-clear
                        @pressEnter="applyFilter"
                    />
                </a-col>
            </a-row>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 8px;">
                <a-button @click="resetFilter" style="color: #cbd5e1; border-color: rgba(255,255,255,0.2); background: transparent;">Xoá lọc</a-button>
                <a-button type="primary" style="background: #8b5cf6; border: none;" @click="applyFilter" :loading="loading">Tìm Kiếm</a-button>
            </div>
        </a-card>

        <a-card style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);" :bodyStyle="{padding: 0}">
            <a-table 
                :data-source="dealers" 
                :columns="columns" 
                :loading="loading"
                :pagination="pagination"
                @change="handleTableChange"
                @expand="fetchPurchases"
                expandRowByClick
                row-key="id"
            >
                <template #bodyCell="{ column, record }">
                    <template v-if="column.key === 'name'">
                        <div style="font-weight:700;">{{ record.full_name || 'Khách' }}</div>
                    </template>
                    <template v-if="column.key === 'api_key'">
                        <div v-if="record.api_key" style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-family: monospace; color: #a78bfa; background: rgba(139,92,246,0.1); padding: 2px 6px; border-radius: 4px;">
                                {{ record.api_key.substring(0, 10) }}...
                            </span>
                            <a-tooltip title="Copy">
                                <a-button size="small" type="text" style="color:#a78bfa" @click="copyKey(record.api_key)">
                                    <i class="ti ti-copy"></i>
                                </a-button>
                            </a-tooltip>
                            <a-tooltip title="Cấp mới Key">
                                <a-button size="small" type="text" style="color:#ef4444" @click="generateKey(record)">
                                    <i class="ti ti-refresh"></i>
                                </a-button>
                            </a-tooltip>
                        </div>
                        <div v-else>
                            <a-button size="small" type="dashed" @click="generateKey(record)">Tạo API Key</a-button>
                        </div>
                    </template>
                    <template v-if="column.key === 'status'">
                        <a-tag color="success">Đang hoạt động</a-tag>
                    </template>
                    <template v-if="column.key === 'orders_count'">
                        <strong>{{ record.orders_count || 0 }}</strong> đơn
                    </template>
                    <template v-if="column.key === 'revenue'">
                        <strong style="color: #10b981;">{{ fmt(record.orders_sum_total_amount) }}</strong>
                    </template>
                    <template v-if="column.key === 'action'">
                        <a-space>
                            <a-button type="primary" ghost size="small" @click.stop="openPriceModal(record)">
                                <i class="ti ti-currency-dollar me-1"></i> Giá Sỉ
                            </a-button>
                            <a-popconfirm title="Hủy tư cách CTV của người này?" @confirm.stop="toggleDealer(record, false)">
                                <a-button danger size="small" @click.stop><i class="ti ti-x"></i> Gỡ</a-button>
                            </a-popconfirm>
                        </a-space>
                    </template>
                </template>

                <template #expandedRowRender="{ record }">
                    <div style="padding: 16px; background-color: rgba(139, 92, 246, 0.05); border-radius: 8px;">
                        <h4 style="color:#c4b5fd; margin-bottom: 16px;"><i class="ti ti-shopping-cart-check"></i> Lịch sử mua hàng</h4>
                        <a-spin :spinning="purchasesMap[record.id]?.loading">
                            <a-table 
                                :dataSource="purchasesMap[record.id]?.data || []" 
                                :columns="innerColumns" 
                                :pagination="false"
                                size="small"
                                rowKey="product_id"
                                bordered
                            >
                                <template #bodyCell="{ column, record: innerRecord }">
                                    <template v-if="column.key === 'total_qty'">
                                        <a-tag color="purple">x{{ innerRecord.total_qty }}</a-tag>
                                    </template>
                                    <template v-if="column.key === 'sub_total'">
                                        <span style="color: #10b981; font-weight: bold;">{{ fmt(innerRecord.sub_total) }}</span>
                                    </template>
                                </template>
                                <template #emptyText>
                                    <span v-if="!purchasesMap[record.id]?.loading">Chưa có dữ liệu mua hàng.</span>
                                </template>
                            </a-table>
                            <div style="text-align: right; margin-top: 12px; font-weight: bold; font-size: 15px;">
                                Tổng chi tiêu: <span style="color: #8b5cf6;">{{ fmt(record.orders_sum_total_amount) }}</span>
                            </div>
                        </a-spin>
                    </div>
                </template>
            </a-table>
        </a-card>

        <!-- Modal Bảng Giá -->
        <a-modal 
            v-model:open="priceModal.visible" 
            :title="`Bảng giá sỉ - ${priceModal.dealer?.full_name}`" 
            width="820px"
            :footer="null"
        >
            <p style="color: #94a3b8; font-size: 13px;">Bỏ trống nếu muốn CTV mua với giá gốc mặc định (VNĐ / USD).</p>
            <a-table 
                :data-source="priceModal.prices" 
                :columns="priceColumns" 
                :loading="priceModal.loading"
                size="small"
                row-key="product_id"
                bordered
            >
                <template #bodyCell="{ column, record }">
                    <template v-if="column.key === 'retail_price'">
                        <span style="opacity: 0.7; text-decoration: line-through;">{{ fmt(record.retail_price) }}</span>
                    </template>
                    <template v-if="column.key === 'dealer_price'">
                        <a-input-number 
                            v-model:value="record.dealer_price" 
                            :min="0"
                            :step="1000"
                            style="width: 125px;"
                            placeholder="Giá VNĐ..."
                            @blur="savePrice(record)"
                            @pressEnter="savePrice(record)"
                        />
                    </template>
                    <template v-if="column.key === 'retail_price_usd'">
                        <span style="opacity: 0.7; text-decoration: line-through;">${{ record.retail_price_usd ? record.retail_price_usd : 0 }}</span>
                    </template>
                    <template v-if="column.key === 'dealer_price_usd'">
                        <a-input-number 
                            v-model:value="record.dealer_price_usd" 
                            :min="0"
                            :step="0.01"
                            style="width: 125px;"
                            placeholder="Giá USD ($)..."
                            @blur="savePrice(record)"
                            @pressEnter="savePrice(record)"
                        />
                    </template>
                </template>
            </a-table>
        </a-modal>

        <!-- Modal Thêm CTV -->
        <a-modal 
            v-model:open="addModal.visible" 
            title="Thêm Cộng Tác Viên Mới" 
            :footer="null"
        >
            <div style="margin-bottom: 16px;">
                <a-input-search
                    v-model:value="addModal.search"
                    placeholder="Tìm theo Tên hoặc Telegram ID..."
                    enter-button="Tìm"
                    @search="searchCustomers"
                />
            </div>
            
            <a-list 
                :loading="addModal.loading" 
                item-layout="horizontal" 
                :data-source="addModal.customers"
            >
                <template #renderItem="{ item }">
                    <a-list-item>
                        <template #actions>
                            <a-button type="primary" size="small" style="background:#8b5cf6;" @click="toggleDealer(item, true)">
                                Thêm làm CTV
                            </a-button>
                        </template>
                        <a-list-item-meta :description="`Telegram ID: ${item.telegram_id}`">
                            <template #title>
                                <strong>{{ item.full_name || 'Khách' }}</strong>
                            </template>
                            <template #avatar>
                                <a-avatar style="background-color: #8b5cf6">{{ (item.full_name || 'K')[0].toUpperCase() }}</a-avatar>
                            </template>
                        </a-list-item-meta>
                    </a-list-item>
                </template>
            </a-list>
        </a-modal>
    </div>
</a-config-provider>
</template>
