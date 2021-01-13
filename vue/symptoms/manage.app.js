import Vue from 'vue';
import Vuex from 'vuex'
import ManageSymptoms from "./ManageSymptoms";

Vue.use(Vuex);

new Vue({
    render: h => h(ManageSymptoms)
}).$mount('#app');
