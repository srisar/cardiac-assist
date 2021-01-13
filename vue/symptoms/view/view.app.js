import Vue from 'vue';
import Vuex from 'vuex'

import ViewSymptom from "./ViewSymptom";

Vue.use(Vuex);

new Vue({
    render: h => h(ViewSymptom)
}).$mount('#app');
