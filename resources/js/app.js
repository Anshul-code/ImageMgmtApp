import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'
import router from './router';
import { createPinia } from 'pinia'

const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(router);
app.mount('#app');

