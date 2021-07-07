import Vue from "vue";
import VueRouter from "vue-router";
import HomepageView from "./HomepageView";

import store from "./vuex.store";
import AppView from "./AppView";
import AppointmentsView from "./AppointmentsView";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: HomepageView
    },
    {
        path: "/appointments",
        component: AppointmentsView,
    }
];

const router = new VueRouter( { routes } );

new Vue( {
    render: h => h( AppView ),
    store: store,
    router: router,
} ).$mount( "#app" );
