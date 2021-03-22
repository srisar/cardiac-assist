import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from "vue-router";

import store from "./store"
import BasicView from "./BasicView";
import DiagnosesView from "./DiagnosesView";
import SpecialInvestigationsView from "./SpecialInvestigationsView";
import AppView from "./AppView";
import EditVisitDetails from "./EditVisitDetails";


Vue.use(Vuex)
Vue.use(VueRouter)


const routes = [
    {path: '', component: BasicView},
    {path: '/diagnoses', component: DiagnosesView},
    {path: '/special', component: SpecialInvestigationsView},
    {path: '/edit/:id', component: EditVisitDetails},
]

const router = new VueRouter({
    routes
})


new Vue({
    render: h => h(AppView),
    store: store,
    router
}).$mount("#app")
