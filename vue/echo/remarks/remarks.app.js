import Vue from 'vue'

import Store from './store'
import EchoRemarks from "./EchoRemarks";

new Vue({
    render: h => h(EchoRemarks),
    store: Store
}).$mount('#app')
