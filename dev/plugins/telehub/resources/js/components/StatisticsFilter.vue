<script>
import { defineComponent, ref, reactive, computed, onMounted } from 'vue'
import { theme } from 'ant-design-vue'
import dayjs from 'dayjs'

export default defineComponent({
    name: 'StatisticsFilter',
    props: {
        apiUrl:       { type: String, required: true },
        isAdmin:      { type: Boolean, default: false },
        tenants:      { type: Array, default: () => [] },
        initDateFrom: { type: String, default: '' },
        initDateTo:   { type: String, default: '' },
        initMonthYear:{ type: String, default: '' },
        initTenantId: { type: String, default: '' },
        staticsUrl:   { type: String, required: true },
    },
    setup(props) {
        // Theme Config
        const antTheme = {
            algorithm: theme.darkAlgorithm,
            token: {
                colorPrimary: '#3b82f6', // Clean blue
                borderRadius: 8,
                colorBgContainer: '#1e293b', // Slate 800
                colorBgElevated: '#334155', // Slate 700
                colorBorder: 'rgba(59, 130, 246, 0.3)',
            }
        }

        const filter = reactive({
            dateRange: [],
            monthYearObj: null,
            date_from:  props.initDateFrom,
            date_to:    props.initDateTo,
            month_year: props.initMonthYear,
            tenant_id:  props.initTenantId ? props.initTenantId : undefined,
            customer_id: [],
            product_id: [],
        })

        // Data State
        const loading       = ref(false)
        const totalRevenue  = ref(0)
        const totalOrders   = ref(0)
        const customerStats = ref([])
        const topProducts   = ref([])
        const tenantStats   = ref([])
        const chartLabels   = ref([])
        const chartData     = ref([])
        const allCustomers  = ref([])
        const allProducts   = ref([])
        const chartInstance = ref(null)
        const searchCustomer= ref('')
        const comboStats         = ref([])
        const totalComboOrders   = ref(0)
        const totalBonusGiven    = ref(0)

        // Computed
        const filteredCustomers = computed(() => {
            if (!searchCustomer.value) return customerStats.value
            const q = searchCustomer.value.toLowerCase()
            return customerStats.value.filter(c =>
                c.full_name.toLowerCase().includes(q) ||
                String(c.telegram_id).includes(q)
            )
        })

        function fmt(n) {
            return new Intl.NumberFormat('vi-VN').format(n || 0) + '₫'
        }

        async function fetchData() {
            loading.value = true
            try {
                const params = new URLSearchParams()
                if (filter.date_from)  params.set('date_from',  filter.date_from)
                if (filter.date_to)    params.set('date_to',    filter.date_to)
                if (filter.month_year) params.set('month_year', filter.month_year)
                if (filter.tenant_id)  params.set('tenant_id',  filter.tenant_id)
                
                if (filter.customer_id && filter.customer_id.length > 0) {
                    params.set('customer_id', filter.customer_id.join(','))
                }
                if (filter.product_id && filter.product_id.length > 0) {
                    params.set('product_id', filter.product_id.join(','))
                }

                const resp = await fetch(props.apiUrl + '?' + params.toString(), {
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                
                if (!resp.ok) return;

                const json = await resp.json()
                const d = json.data || {}

                totalRevenue.value       = d.total_revenue || 0
                totalOrders.value        = d.total_orders || 0
                customerStats.value      = d.customer_stats || []
                topProducts.value        = d.top_products || []
                tenantStats.value        = d.tenant_stats || []
                chartLabels.value        = d.chart_labels || []
                chartData.value          = d.chart_data || []
                allCustomers.value       = d.all_customers || []
                allProducts.value        = d.all_products || []
                comboStats.value         = d.combo_stats || []
                totalComboOrders.value   = d.total_combo_orders || 0
                totalBonusGiven.value    = d.total_bonus_given || 0

                updateChart()
            } finally {
                loading.value = false
            }
        }

        function updateChart() {
            const ctx = document.getElementById('chart-daily-vue')
            if (!ctx) return
            if (chartInstance.value) {
                chartInstance.value.destroy()
                chartInstance.value = null
            }
            if (typeof Chart === 'undefined') return
            chartInstance.value = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels.value,
                    datasets: [{
                        label: 'Doanh thu',
                        data: chartData.value,
                        fill: true,
                        backgroundColor: 'rgba(59,130,246,.13)', // Blue
                        borderColor: '#3b82f6', // Blue
                        pointBackgroundColor: '#3b82f6',
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        tension: 0.4,
                        borderWidth: 2.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11 }, maxTicksLimit: 12 } },
                        y: {
                            grid: { color: 'rgba(255,255,255,.05)' },
                            ticks: { font: { size: 11 }, callback: v => new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(v) + '₫' }
                        }
                    }
                }
            })
        }
        
        function setDateRange(type) {
            filter.monthYearObj = null;
            const today = dayjs();
            if (type === 'today') {
                filter.dateRange = [today, today];
            } else if (type === 'yesterday') {
                const yesterday = today.subtract(1, 'day');
                filter.dateRange = [yesterday, yesterday];
            } else if (type === 'this_week') {
                filter.dateRange = [today.startOf('week'), today];
            } else if (type === 'this_month') {
                filter.dateRange = [today.startOf('month'), today];
            }
            applyFilter();
        }

        function applyFilter() {
            if (filter.dateRange && filter.dateRange.length === 2) {
                filter.date_from = filter.dateRange[0].format('YYYY-MM-DD');
                filter.date_to = filter.dateRange[1].format('YYYY-MM-DD');
            } else {
                filter.date_from = ''
                filter.date_to = ''
            }

            if (filter.monthYearObj) {
                filter.month_year = filter.monthYearObj.format('YYYY-MM')
            } else {
                filter.month_year = ''
            }
            fetchData()
        }

        function resetFilter() {
            filter.date_from   = ''
            filter.date_to     = ''
            filter.month_year  = ''
            filter.tenant_id   = undefined
            filter.customer_id = []
            filter.product_id  = []
            filter.dateRange   = []
            filter.monthYearObj = null
            searchCustomer.value = ''
            fetchData()
        }

        onMounted(() => {
            fetchData()
        })

        const customerColumns = [
            { title: 'Khách hàng', dataIndex: 'full_name', key: 'name' },
            { title: 'Số mặt hàng', dataIndex: 'products_count', key: 'products_count', align: 'right' },
            { title: 'Tổng chi tiêu', dataIndex: 'grand_total', key: 'grand_total', align: 'right', sorter: (a, b) => a.grand_total - b.grand_total },
        ];

        const innerColumns = [
            { title: 'Tên sản phẩm', dataIndex: 'product_name', key: 'product_name' },
            { title: 'Số lượng', dataIndex: 'total_qty', key: 'total_qty', align: 'center' },
            { title: 'Đơn giá', key: 'unit_price', align: 'right' },
            { title: 'Thành tiền', dataIndex: 'sub_total', key: 'sub_total', align: 'right' },
        ];

        const topProductColumns = [
            { title: 'Sản phẩm', dataIndex: 'product_name', key: 'name' },
            { title: 'Lượt mua', dataIndex: 'total_qty', key: 'qty', align: 'center' },
            { title: 'Doanh thu', dataIndex: 'total_revenue', key: 'revenue', align: 'right' },
        ];

        const tenantColumns = [
            { title: 'Tenant', dataIndex: 'username', key: 'username' },
            { title: 'Email', dataIndex: 'email', key: 'email' },
            { title: 'Đơn hàng', dataIndex: 'period_orders', key: 'orders', align: 'right' },
            { title: 'Doanh thu', dataIndex: 'period_revenue', key: 'revenue', align: 'right' },
        ];

        const comboColumns = [
            { title: 'Combo', dataIndex: 'label', key: 'label' },
            { title: 'Loại', dataIndex: 'combo_type', key: 'combo_type', align: 'center' },
            { title: 'SL tối thiểu', dataIndex: 'min_quantity', key: 'min_qty', align: 'center' },
            { title: 'Ưu đãi', key: 'offer', align: 'center' },
            { title: 'Lượt dùng', dataIndex: 'usage_count', key: 'usage', align: 'center', sorter: (a, b) => a.usage_count - b.usage_count },
            { title: 'Acc tặng ra', dataIndex: 'total_bonus_given', key: 'bonus', align: 'center' },
            { title: 'Doanh thu', dataIndex: 'combo_revenue', key: 'revenue', align: 'right', sorter: (a, b) => a.combo_revenue - b.combo_revenue },
        ];

        return {
            filter, loading, totalRevenue, totalOrders,
            customerStats, topProducts, tenantStats,
            allCustomers, allProducts,
            filteredCustomers, searchCustomer,
            comboStats, totalComboOrders, totalBonusGiven, comboColumns,
            fmt, applyFilter, resetFilter, setDateRange,
            antTheme, customerColumns, innerColumns, topProductColumns, tenantColumns
        }
    },
})
</script>

<template>
<a-config-provider :theme="antTheme">
    <div style="padding: 10px;">
        <!-- ─── FILTER BAR ───────────────────────────────────────────────── -->
        <a-card style="margin-bottom: 24px; border-radius: 12px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <span style="font-size:13px; font-weight:700; color:rgba(147,197,253,.8); text-transform: uppercase;">
                    <i class="ti ti-adjustments-horizontal me-1"></i> Bộ lọc thống kê nâng cao
                </span>
                <a-space>
                    <a-button size="small" type="dashed" @click="setDateRange('today')">Hôm nay</a-button>
                    <a-button size="small" type="dashed" @click="setDateRange('yesterday')">Hôm qua</a-button>
                    <a-button size="small" type="dashed" @click="setDateRange('this_week')">Tuần này</a-button>
                    <a-button size="small" type="dashed" @click="setDateRange('this_month')">Tháng này</a-button>
                </a-space>
            </div>
            
            <a-row :gutter="[16, 16]">
                <a-col :xs="24" :md="6">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Khoảng thời gian</div>
                    <a-range-picker 
                        v-model:value="filter.dateRange" 
                        format="DD/MM/YYYY" 
                        style="width: 100%" 
                        @change="filter.monthYearObj = null"
                    />
                </a-col>
                
                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Tháng / Năm</div>
                    <a-date-picker 
                        v-model:value="filter.monthYearObj" 
                        picker="month" 
                        format="MM/YYYY" 
                        style="width: 100%" 
                        @change="filter.dateRange = []"
                    />
                </a-col>

                <a-col :xs="24" :md="6">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Sản phẩm</div>
                    <a-select
                        v-model:value="filter.product_id"
                        mode="multiple"
                        style="width: 100%"
                        placeholder="Chọn sản phẩm..."
                        :options="allProducts.map(p => ({value: String(p.id), label: `${p.name} (${fmt(p.price)})`}))"
                        show-search
                        optionFilterProp="label"
                    />
                </a-col>

                <a-col :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Khách hàng</div>
                    <a-select
                        v-model:value="filter.customer_id"
                        mode="multiple"
                        style="width: 100%"
                        placeholder="Chọn khách hàng..."
                        :options="allCustomers.map(c => ({value: String(c.id), label: c.full_name || `TG: ${c.telegram_id}`}))"
                        show-search
                        optionFilterProp="label"
                    />
                </a-col>

                <a-col v-if="isAdmin" :xs="24" :md="4">
                    <div style="color:#bfdbfe; font-size:12px; font-weight:600; margin-bottom:6px;">Tenant</div>
                    <a-select
                        v-model:value="filter.tenant_id"
                        style="width: 100%"
                        placeholder="Tất cả tenant"
                        allow-clear
                        :options="tenants.map(t => ({value: String(t.id), label: `${t.username} (${t.email})`}))"
                    />
                </a-col>
            </a-row>

            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 8px;">
                <a-button @click="resetFilter">Xoá lọc</a-button>
                <a-button type="primary" @click="applyFilter" :loading="loading">Lọc Dữ Liệu</a-button>
            </div>
        </a-card>

        <a-spin :spinning="loading" tip="Đang tải dữ liệu...">
            <!-- ─── KPI CARDS ──────────────────────────────────────────── -->
            <a-row :gutter="[16, 16]" style="margin-bottom: 24px;">
                <a-col :xs="24" :sm="8">
                    <a-card style="border-radius: 12px; background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; border: none;">
                        <div style="font-size:12px; font-weight:600; text-transform:uppercase; opacity:0.8;">Tổng Doanh Thu</div>
                        <div style="font-size:26px; font-weight:800; margin-top:8px;">{{ fmt(totalRevenue) }}</div>
                    </a-card>
                </a-col>
                <a-col :xs="24" :sm="8">
                    <a-card style="border-radius: 12px; background: linear-gradient(135deg, #0f766e, #10b981); color: white; border: none;">
                        <div style="font-size:12px; font-weight:600; text-transform:uppercase; opacity:0.8;">Tổng Đơn Hàng</div>
                        <div style="font-size:26px; font-weight:800; margin-top:8px;">{{ totalOrders.toLocaleString() }}</div>
                    </a-card>
                </a-col>
                <a-col :xs="24" :sm="8">
                    <a-card style="border-radius: 12px; background: linear-gradient(135deg, #7c3aed, #a78bfa); color: white; border: none;">
                        <div style="font-size:12px; font-weight:600; text-transform:uppercase; opacity:0.8;">🎁 Đơn Combo / Acc Tặng</div>
                        <div style="font-size:22px; font-weight:800; margin-top:8px;">{{ totalComboOrders.toLocaleString() }} <span style="font-size:14px;opacity:0.8">đơn</span></div>
                        <div style="font-size:14px; opacity:0.85;">{{ totalBonusGiven.toLocaleString() }} acc tặng ra</div>
                    </a-card>
                </a-col>
            </a-row>

            <!-- ─── CHARTS AND TOP PRODUCTS ────────────────────────────────────────── -->
            <a-row :gutter="[16, 16]" style="margin-bottom: 24px;">
                <a-col :xs="24" :lg="16">
                    <a-card title="Doanh thu theo ngày" style="border-radius: 12px; height: 100%;">
                        <div style="padding:16px; position:relative; height:250px;">
                            <canvas id="chart-daily-vue"></canvas>
                        </div>
                    </a-card>
                </a-col>
                <a-col :xs="24" :lg="8">
                    <a-card title="Top sản phẩm" style="border-radius: 12px; height: 100%;" :bodyStyle="{padding: 0}">
                        <a-table 
                            :dataSource="topProducts" 
                            :columns="topProductColumns" 
                            size="small" 
                            :pagination="false"
                            rowKey="product_id"
                        >
                            <template #bodyCell="{ column, record }">
                                <template v-if="column.key === 'revenue'">
                                    <span style="color: #10b981; font-weight: 600;">{{ fmt(record.total_revenue) }}</span>
                                </template>
                            </template>
                        </a-table>
                    </a-card>
                </a-col>
            </a-row>

            <!-- ─── ADMIN: TENANT TABLE ─────────────────────────────── -->
            <a-card v-if="isAdmin && tenantStats.length" title="Doanh thu theo Tenant" style="border-radius: 12px; margin-bottom: 24px;" :bodyStyle="{padding: 0}">
                <a-table 
                    :dataSource="tenantStats" 
                    :columns="tenantColumns" 
                    :pagination="{ pageSize: 10 }"
                    rowKey="id"
                >
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'revenue'">
                            <span style="color: #10b981; font-weight: 600;">{{ fmt(record.period_revenue) }}</span>
                        </template>
                        <template v-if="column.key === 'username'">
                            <strong>{{ record.username }}</strong>
                        </template>
                    </template>
                </a-table>
            </a-card>

            <!-- ─── CUSTOMER TABLE ───────────────────────────────────── -->
            <a-card title="Chi tiết khách hàng" style="border-radius: 12px;" :bodyStyle="{padding: 0}">
                <template #extra>
                    <a-input-search
                        v-model:value="searchCustomer"
                        placeholder="Tìm tên / Telegram ID..."
                        style="width: 250px"
                    />
                </template>
                <a-table 
                    :dataSource="filteredCustomers" 
                    :columns="customerColumns" 
                    :pagination="{ pageSize: 15 }"
                    rowKey="customer_id"
                    expandRowByClick
                >
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'name'">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <a-avatar :style="{ backgroundColor: '#3b82f6', verticalAlign: 'middle' }">
                                    {{ record.full_name.charAt(0).toUpperCase() }}
                                </a-avatar>
                                <div>
                                    <div style="font-weight:700;">{{ record.full_name }}</div>
                                    <div style="font-size:12px; opacity:0.6;"><i class="ti ti-brand-telegram"></i> {{ record.telegram_id }}</div>
                                </div>
                            </div>
                        </template>
                        <template v-if="column.key === 'products_count'">
                            {{ record.products.length }} mặt hàng
                        </template>
                        <template v-if="column.key === 'grand_total'">
                            <span style="color: #10b981; font-weight: 600; font-size: 15px;">{{ fmt(record.grand_total) }}</span>
                        </template>
                    </template>

                    <!-- Expanded Accordion Detail -->
                    <template #expandedRowRender="{ record }">
                        <div style="padding: 16px; background-color: rgba(255, 255, 255, 0.03); border-radius: 8px;">
                            <h4 style="color:#93c5fd; margin-bottom: 16px;"><i class="ti ti-shopping-cart-check"></i> Chi tiết mua hàng</h4>
                            <a-table 
                                :dataSource="record.products" 
                                :columns="innerColumns" 
                                :pagination="false"
                                size="small"
                                rowKey="product_id"
                                bordered
                            >
                                <template #bodyCell="{ column, record: innerRecord }">
                                    <template v-if="column.key === 'total_qty'">
                                        <a-tag color="blue">x{{ innerRecord.total_qty }}</a-tag>
                                    </template>
                                    <template v-if="column.key === 'unit_price'">
                                        <div v-if="innerRecord.unit_price_usd" style="line-height:1.3;">
                                            <div style="color:#f59e0b; font-weight:600; font-size:13px;">
                                                ${{ innerRecord.unit_price_usd }}/acc
                                            </div>
                                            <div style="color:#64748b; font-size:11px;">
                                                &asymp; {{ fmt(innerRecord.unit_price_vnd) }}/acc
                                            </div>
                                        </div>
                                        <div v-else style="color:#94a3b8; font-size:12px;">
                                            {{ fmt(innerRecord.unit_price_vnd) }}/acc
                                        </div>
                                    </template>
                                    <template v-if="column.key === 'sub_total'">
                                        <span style="color: #10b981; font-weight: bold;">{{ fmt(innerRecord.sub_total) }}</span>
                                    </template>
                                </template>
                            </a-table>
                            <div style="text-align: right; margin-top: 12px; font-weight: bold; font-size: 15px;">
                                Tổng cộng: <span style="color: #3b82f6;">{{ fmt(record.grand_total) }}</span>
                            </div>
                        </div>
                    </template>
                </a-table>
            </a-card>

            <!-- ─── COMBO ANALYTICS ─────────────────────────────────── -->
            <a-card v-if="comboStats.length" style="border-radius: 12px; margin-top: 24px; background: linear-gradient(135deg, #1e1b4b 0%, #2d1b69 100%); border: 1px solid rgba(167,139,250,.3);" :bodyStyle="{padding: 0}">
                <template #title>
                    <span style="color:#a78bfa; font-weight:700;">🎁 Combo Analytics — Hiệu quả ưu đãi mua nhiều</span>
                </template>
                <a-table
                    :dataSource="comboStats"
                    :columns="comboColumns"
                    :pagination="false"
                    size="small"
                    rowKey="combo_id"
                >
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'label'">
                            <strong style="color:#c4b5fd;">{{ record.label || `Combo #${record.combo_id}` }}</strong>
                            <div style="font-size:11px; color:#7c3aed;">≥ {{ record.min_quantity }} acc</div>
                        </template>
                        <template v-if="column.key === 'combo_type'">
                            <a-tag :color="record.combo_type === 'bonus' ? 'green' : 'orange'">
                                {{ record.combo_type === 'bonus' ? '🎁 Tặng acc' : '🏷️ Giảm giá' }}
                            </a-tag>
                        </template>
                        <template v-if="column.key === 'offer'">
                            <span v-if="record.combo_type === 'bonus'" style="color:#10b981;font-weight:600;">+{{ record.combo_bonus_qty }} acc</span>
                            <span v-else-if="record.discount_percent" style="color:#f59e0b;font-weight:600;">-{{ record.discount_percent }}%/acc</span>
                            <span v-else style="color:#f59e0b;font-weight:600;">-{{ fmt(record.discount_amount) }}/acc</span>
                        </template>
                        <template v-if="column.key === 'usage'">
                            <a-tag color="purple">{{ record.usage_count }} lần</a-tag>
                        </template>
                        <template v-if="column.key === 'bonus'">
                            <span v-if="record.total_bonus_given" style="color:#10b981;font-weight:600;">{{ record.total_bonus_given }} acc</span>
                            <span v-else style="opacity:0.4;">—</span>
                        </template>
                        <template v-if="column.key === 'revenue'">
                            <span style="color: #10b981; font-weight: 600;">{{ fmt(record.combo_revenue) }}</span>
                        </template>
                    </template>
                </a-table>
            </a-card>
        </a-spin>
    </div>
</a-config-provider>
</template>
