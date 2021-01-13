import Vue from 'vue';
import Vuex from 'vuex';

import ManageVisit from "./ManageVisit";

Vue.use(Vuex);

new Vue({
    render: h => h(ManageVisit)
}).$mount("#app");
