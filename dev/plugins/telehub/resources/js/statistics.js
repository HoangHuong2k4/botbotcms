import { createApp } from "vue"
import Antd from "ant-design-vue"
import "ant-design-vue/dist/reset.css"
import StatisticsFilter from "./components/StatisticsFilter.vue"
import OrderFilter from "./components/OrderFilter.vue"

document.addEventListener("DOMContentLoaded", () => {
    // 1) Statistics App
    const statEl = document.getElementById("stat-vue-app")
    if (statEl) {
        const app = createApp(StatisticsFilter, {
            apiUrl:        statEl.dataset.apiUrl,
            isAdmin:       statEl.dataset.isAdmin === "1",
            tenants:       JSON.parse(statEl.dataset.tenants  || "[]"),
            initDateFrom:  statEl.dataset.dateFrom   || "",
            initDateTo:    statEl.dataset.dateTo     || "",
            initMonthYear: statEl.dataset.monthYear  || "",
            initTenantId:  statEl.dataset.tenantId   || "",
            staticsUrl:    statEl.dataset.staticsUrl || "",
        })
        app.use(Antd)
        app.mount(statEl)
    }

    // 2) Orders App
    const orderEl = document.getElementById("telehub-orders-app")
    if (orderEl) {
        const orderApp = createApp({})
        orderApp.component('order-filter', OrderFilter)
        orderApp.use(Antd)
        orderApp.mount('#telehub-orders-app')
    }
})
