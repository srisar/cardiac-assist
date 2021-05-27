import Vue from "vue";
import ManageDrugs from "./ManageDrugs";

import Store from "./store";

new Vue({
    render: h => h(ManageDrugs),
    store: Store
}).$mount("#app");
