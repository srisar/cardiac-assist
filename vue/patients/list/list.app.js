import Vue from "vue";
import VueRouter from "vue-router";
import ListAllPatients from "./ListAllPatients";

import {store} from "./vuex.store";
import SearchResults from "./SearchResults";
import ListView from "./ListView";

Vue.use(VueRouter);

const routes = [
    {
        path: "",
        component: ListAllPatients
    },
    {
        path: "/search/:keyword",
        component: SearchResults
    }
];

const router = new VueRouter({routes});

new Vue({
    render: h => h(ListView),
    store: store,
    router: router,
}).$mount("#app");
