import Vue from 'vue';
import Vuex from 'vuex'

import ViewSymptom from "./ViewDisease";

Vue.use(Vuex);

import store from "./store";

new Vue({
    render: h => h(ViewSymptom),
    store: store,
}).$mount('#app');
