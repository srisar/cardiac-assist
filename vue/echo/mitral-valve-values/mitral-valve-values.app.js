import Vue from 'vue';
import Vuex from 'vuex'
import MitralValveValues from "./MitralValveValues";

Vue.use(Vuex);

new Vue({
    render: h => h(MitralValveValues),
}).$mount('#app');
