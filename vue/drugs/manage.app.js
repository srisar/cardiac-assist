import Vue from "vue";
import VueRouter from "vue-router";
import ManageDrugs from "./ManageDrugs";

import Store from "./store";
import SaveDrug from "./components/SaveDrug";
import EditDrug from "./components/EditDrug";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: SaveDrug
    },
    {
        path: "/add",
        component: SaveDrug
    },
    {
        path: "/edit/:id",
        component: EditDrug
    },
];

const router = new VueRouter({
    routes
});

new Vue({
    render: h => h(ManageDrugs),
    store: Store,
    router: router,
}).$mount("#app");
