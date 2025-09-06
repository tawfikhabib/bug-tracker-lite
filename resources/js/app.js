import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './Pages/Dashboard.vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import '../css/app.css'

const app = createApp(App)
app.use(createPinia())
app.use(Toast, {
  position: 'top-right',
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
})
app.mount('#app')