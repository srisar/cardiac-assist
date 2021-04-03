import Vue from 'vue'
import AllValues from "./AllValues"

import Store from './store'

new Vue({
    render: h => h(AllValues),
    store: Store
}).$mount('#app')
