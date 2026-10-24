import { createApp } from 'vue'
import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/reset.css'
import DealerManager from './components/DealerManager.vue'

document.addEventListener("DOMContentLoaded", () => {
    const mountEl = document.getElementById('dealer-manager-app')
    if (mountEl) {
        const app = createApp({})
        app.component('dealer-manager', DealerManager)
        app.use(Antd)
        app.mount('#dealer-manager-app')
    }
})
