import Vue from "vue";
import VueRouter from "vue-router";

import Store from "./store";
import ManageReferralLetters from "./ManageReferralLetters";
import SaveLetters from "./components/SaveLetters";
import EditLetters from "./components/EditLetters";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: SaveLetters
    },
    {
        path: "/add",
        component: SaveLetters
    },
    {
        path: "/edit/:id",
        component: EditLetters
    },
];

const router = new VueRouter({
    routes
});

new Vue({
    render: h => h(ManageReferralLetters),
    store: Store,
    router: router,
}).$mount("#app");
