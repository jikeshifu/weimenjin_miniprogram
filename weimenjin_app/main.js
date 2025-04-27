import { createApp } from 'vue';
import App from './App.vue';
import './permission';

// import Vconsole from 'vconsole';
// new Vconsole();

const app = createApp(App);

app.config.productionTip = false;

// 挂载应用
app.mount('#app');