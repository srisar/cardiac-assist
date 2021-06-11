import Vue from "vue";
import VueRouter from "vue-router";
import HomepageView from "./HomepageView";

import store from "./vuex.store";

const routes = [];

const router = new VueRouter({routes});

new Vue({
    render: h => h(HomepageView),
    store: store,
    router: router,
}).$mount("#app");
