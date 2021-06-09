import Vue from "vue";
import VueRouter from "vue-router";
import ManageSymptoms from "./ManageSymptoms";

import store from "./store";
import SaveSymptom from "./components/SaveSymptom";
import EditSymptom from "./components/EditSymptom";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: SaveSymptom
    },
    {
        path: "/add",
        component: SaveSymptom
    },
    {
        path: "/edit/:id",
        component: EditSymptom
    },
];

const router = new VueRouter({
    routes
});

new Vue({
    render: h => h(ManageSymptoms),
    store: store,
    router: router,
}).$mount("#app");
