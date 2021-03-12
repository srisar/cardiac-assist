import Vue from 'vue';
import Vuex from 'vuex'
import AllValues from "./AllValues";

Vue.use(Vuex);

new Vue({
    render: h => h(AllValues),
}).$mount('#app');
