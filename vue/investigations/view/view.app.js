import Vue from 'vue';
import Vuex from 'vuex'

import ViewInvestigation from "./ViewInvestigation";

Vue.use(Vuex);

import store from "./store";

new Vue({
    render: h => h(ViewInvestigation),
    store: store,
}).$mount('#app');
