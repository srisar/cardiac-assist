import HomepageView from "./HomepageView";

import Vue from 'vue';

import store from './vuex.store'

new Vue({
    render: h => h(HomepageView),
    store : store,
}).$mount("#app");
