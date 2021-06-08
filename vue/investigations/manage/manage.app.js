import Vue from "vue";
import VueRouter from "vue-router";
import ManageInvestigations from "./ManageInvestigations";

import store from "./store";
import SaveInvestigation from "./components/SaveInvestigation";
import EditInvestigation from "./components/EditInvestigation";

Vue.use(VueRouter);

/*
* vue routes
* */
const routes = [
    {
        path: "/",
        component: SaveInvestigation
    },
    {
        path: "/add",
        component: SaveInvestigation
    },
    {
        path: "/edit/:id",
        component: EditInvestigation
    }
];

const router = new VueRouter({
    routes
})

new Vue({
    render: h => h(ManageInvestigations),
    store: store,
    router: router,
}).$mount("#app");
