import Vue from "vue";
import VueRouter from "vue-router";

import store from "./store";
import ManageDiseases from "./ManageDiseases";
import SaveDisease from "./components/SaveDisease";
import EditDisease from "./components/EditDisease";

Vue.use( VueRouter );


const routes = [
    {
        path: "/",
        component: SaveDisease
    },
    {
        path: "/add",
        component: SaveDisease
    },
    {
        path: "/edit/:id",
        component: EditDisease
    },
];

const router = new VueRouter( {
    routes
} );


new Vue( {
    render: h => h( ManageDiseases ),
    store: store,
    router: router,
} ).$mount( "#app" );
