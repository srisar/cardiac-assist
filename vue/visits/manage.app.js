import Vue from 'vue';
import Vuex from 'vuex';

import ManageVisit from "./ManageVisit";
import store from "./store";

Vue.use(Vuex);

new Vue({
    render: h => h(ManageVisit),
    store: store,
}).$mount("#app");
