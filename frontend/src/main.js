import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// ✅ Importação do Bootstrap CSS e JS
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js' // inclui Popper

const app = createApp(App)
app.use(router)
app.mount('#app')
