import Vue from 'vue';
import ManageInvestigations from "./ManageInvestigations";

import store from "./store";

new Vue({
    render: h => h(ManageInvestigations),
    store: store,
}).$mount("#app");
