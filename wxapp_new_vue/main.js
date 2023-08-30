import Vue from 'vue'
import App from './App'
import './permission';

Vue.config.productionTip = false;

App.mpType = 'app'

// import Vconsole from 'vconsole';
// new Vconsole();


const app = new Vue({
    ...App
})
app.$mount()
