import re

file_path = "/home/huong/web/cms.cataishop.shop/public_html/dev/plugins/telehub/resources/js/components/StatisticsFilter.vue"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Add VueDatePicker import and component registration
content = content.replace(
    "import { defineComponent, ref, reactive, computed, onMounted } from 'vue'",
    "import { defineComponent, ref, reactive, computed, onMounted, watch } from 'vue'\nimport VueDatePicker from '@vuepic/vue-datepicker'\nimport '@vuepic/vue-datepicker/dist/main.css'"
)

content = content.replace(
    "name: 'StatisticsFilter',",
    "name: 'StatisticsFilter',\n    components: { VueDatePicker },"
)

# 2. Add pagination state and datepicker models
content = content.replace(
    "const filter = reactive({",
    "const customerPage = ref(1)\n        const customerPerPage = 15\n\n        const filter = reactive({\n            dateRange: [],\n            monthYearObj: null,"
)

# 3. Add Pagination computed properties
pagination_computed = """
        const totalCustomerPages = computed(() => Math.ceil(filteredCustomers.value.length / customerPerPage))
        
        const paginatedCustomers = computed(() => {
            const start = (customerPage.value - 1) * customerPerPage
            return filteredCustomers.value.slice(start, start + customerPerPage)
        })
        
        const customerPagination = computed(() => {
            const pages = []
            const total = totalCustomerPages.value
            const current = customerPage.value
            for (let i = Math.max(1, current - 2); i <= Math.min(total, current + 2); i++) {
                pages.push(i)
            }
            return pages
        })

        watch(searchCustomer, () => {
            customerPage.value = 1
        })
"""
content = content.replace(
    "const activePeriod = computed(() => {",
    pagination_computed + "\n        const activePeriod = computed(() => {"
)

# 4. Update the applyFilter method to sync date pickers with API payload
apply_filter_replacement = """
        function applyFilter() {
            if (filter.dateRange && filter.dateRange.length === 2) {
                const formatDt = d => {
                    const m = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${d.getFullYear()}-${m}-${day}`;
                };
                filter.date_from = formatDt(filter.dateRange[0])
                filter.date_to = formatDt(filter.dateRange[1])
            } else {
                filter.date_from = ''
                filter.date_to = ''
            }

            if (filter.monthYearObj) {
                const m = String(filter.monthYearObj.month + 1).padStart(2, '0');
                filter.month_year = `${filter.monthYearObj.year}-${m}`
            } else {
                filter.month_year = ''
            }
            customerPage.value = 1
            fetchData()
        }

        function resetFilter() {
            filter.date_from   = ''
            filter.date_to     = ''
            filter.month_year  = ''
            filter.tenant_id   = ''
            filter.customer_id = ''
            filter.product_id  = ''
            filter.dateRange   = []
            filter.monthYearObj = null
            searchCustomer.value = ''
            customerPage.value = 1
            fetchData()
        }
"""
content = re.sub(
    r"function applyFilter\(\) \{[\s\S]*?fetchData\(\)\n\s*\}",
    apply_filter_replacement,
    content
)

# 5. Return pagination props
content = content.replace(
    "searchCustomer,",
    "searchCustomer, customerPage, paginatedCustomers, totalCustomerPages, customerPagination,"
)

# 6. Update the template filter inputs
filter_html_old = """            <!-- Month -->
            <div class="col-md-2 col-sm-6">
                <label class="form-label">Tháng / Năm</label>
                <input type="month" v-model="filter.month_year" @change="onMonthChange"
                    class="form-control" :max="new Date().toISOString().slice(0,7)" />
            </div>

            <!-- Date from -->
            <div class="col-md-2 col-sm-6">
                <label class="form-label">Từ ngày</label>
                <input type="date" v-model="filter.date_from" @change="onDateChange"
                    class="form-control" :max="new Date().toISOString().slice(0,10)" />
            </div>

            <!-- Date to -->
            <div class="col-md-2 col-sm-6">
                <label class="form-label">Đến ngày</label>
                <input type="date" v-model="filter.date_to" @change="onDateChange"
                    class="form-control" :max="new Date().toISOString().slice(0,10)" />
            </div>"""

filter_html_new = """            <!-- Date Range -->
            <div class="col-md-4 col-sm-12">
                <label class="form-label">Khoảng thời gian</label>
                <VueDatePicker v-model="filter.dateRange" range multi-calendars format="dd/MM/yyyy" placeholder="Từ ngày - Đến ngày" auto-apply :enable-time-picker="false" @update:model-value="filter.monthYearObj = null" hide-input-icon class="custom-datepicker" />
            </div>
            
            <!-- Month -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label">Tháng / Năm</label>
                <VueDatePicker v-model="filter.monthYearObj" month-picker format="MM/yyyy" placeholder="Chọn tháng/năm" auto-apply @update:model-value="filter.dateRange = []" hide-input-icon class="custom-datepicker" />
            </div>"""

content = content.replace(filter_html_old, filter_html_new)

# 7. Update Customer Table to use paginatedCustomers and add pagination controls
content = content.replace(
    '<tr v-for="(cs, idx) in filteredCustomers"',
    '<tr v-for="(cs, idx) in paginatedCustomers"'
)
content = content.replace(
    'idx === 0 ? \'rank-1\' : idx === 1 ? \'rank-2\' : idx === 2 ? \'rank-3\' : \'rank-n\'',
    '(idx + (customerPage - 1) * customerPerPage) === 0 ? \'rank-1\' : (idx + (customerPage - 1) * customerPerPage) === 1 ? \'rank-2\' : (idx + (customerPage - 1) * customerPerPage) === 2 ? \'rank-3\' : \'rank-n\''
)
content = content.replace(
    '<span v-if="idx < 3">{{ [\'🥇\',\'🥈\',\'🥉\'][idx] }}</span>',
    '<span v-if="(idx + (customerPage - 1) * customerPerPage) < 3">{{ [\'🥇\',\'🥈\',\'🥉\'][idx + (customerPage - 1) * customerPerPage] }}</span>'
)
content = content.replace(
    '<span v-else>{{ idx + 1 }}</span>',
    '<span v-else>{{ idx + (customerPage - 1) * customerPerPage + 1 }}</span>'
)

pagination_html = """            <div v-if="totalCustomerPages > 1" class="card-footer d-flex align-items-center justify-content-between" style="border-top: 1px solid var(--tblr-border-color); background: rgba(99,102,241,.01); padding: 12px 22px;">
                <p class="m-0 text-muted" style="font-size: 13px;">
                    Hiển thị <span>{{ (customerPage - 1) * 15 + 1 }}</span> đến <span>{{ Math.min(customerPage * 15, filteredCustomers.length) }}</span> trong số <span>{{ filteredCustomers.length }}</span> khách hàng
                </p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item" :class="{ disabled: customerPage === 1 }">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true" @click.prevent="customerPage--">
                            <i class="ti ti-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item" v-for="p in customerPagination" :key="p" :class="{ active: p === customerPage }">
                        <a class="page-link" href="#" @click.prevent="customerPage = p">{{ p }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: customerPage === totalCustomerPages }">
                        <a class="page-link" href="#" @click.prevent="customerPage++">
                            <i class="ti ti-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>"""

content = content.replace(
    "            </div>\n        </div>",
    "            </div>\n" + pagination_html
)

# 8. Add some styles for VueDatePicker to match the dark theme
styles = """
<style>
/* Custom DatePicker Styles for Dark Theme Match */
.custom-datepicker {
    --dp-background-color: rgba(255, 255, 255, 0.07);
    --dp-text-color: #ffffff;
    --dp-hover-color: #312e81;
    --dp-hover-text-color: #ffffff;
    --dp-hover-icon-color: #ffffff;
    --dp-primary-color: #6366f1;
    --dp-primary-text-color: #ffffff;
    --dp-secondary-color: #a5b4fc;
    --dp-border-color: rgba(99, 102, 241, 0.3);
    --dp-menu-border-color: rgba(99, 102, 241, 0.3);
    --dp-border-color-hover: #6366f1;
    --dp-disabled-color: rgba(255, 255, 255, 0.1);
    --dp-scroll-bar-background: rgba(255, 255, 255, 0.1);
    --dp-scroll-bar-color: #6366f1;
    --dp-success-color: #10b981;
    --dp-success-color-disabled: #0f766e;
    --dp-icon-color: #a5b4fc;
    --dp-danger-color: #ef4444;
    --dp-highlight-color: rgba(99, 102, 241, 0.2);
}
.custom-datepicker .dp__input {
    border-radius: 10px;
    height: 40px;
    font-size: 13px;
    box-shadow: none;
    padding-left: 12px;
}
.custom-datepicker .dp__input:focus {
    box-shadow: 0 0 0 3px rgba(99,102,241,.2);
}
.custom-datepicker .dp__input::placeholder {
    color: rgba(255,255,255,.35);
}
.custom-datepicker .dp__theme_light {
    --dp-background-color: #1e1b4b; /* overriding light theme since we are inside a dark card */
    --dp-text-color: #ffffff;
}
</style>
"""

content = content + styles

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Replacement complete.")
