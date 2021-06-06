import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from "vue-router";

import store from "./store"
import BasicView from "./views/BasicView";
import DiagnosesView from "./views/DiagnosesView";
import AppView from "./views/AppView";
import EditVisitDetails from "./views/EditVisitDetails";
import VisitECGView from "./views/special-investigations/VisitECGView";
import VisitLipidsView from "./views/special-investigations/VisitLipidsView";
import VisitCoronaryCTView from "./views/special-investigations/VisitCoronaryCTView";
import VisitEchoView from "./views/special-investigations/VisitEchoView";
import VisitAngiographyView from "./views/special-investigations/VisitAngiographyView";
import PrescriptionView from "./views/intervention/prescriptions/PrescriptionView";
import EditPrescription from "./views/intervention/prescriptions/EditPrescription";


Vue.use(Vuex)
Vue.use(VueRouter)


const routes = [
    {path: '', component: BasicView},
    {path: '/diagnoses', component: DiagnosesView},
    {path: '/edit/:id', component: EditVisitDetails},

    {path: '/special/ecg', component: VisitECGView},
    {path: '/special/lipids', component: VisitLipidsView},
    {path: '/special/coronary-ct', component: VisitCoronaryCTView},
    {path: '/special/echo', component: VisitEchoView},
    {path: '/special/angio', component: VisitAngiographyView},

    {path: '/prescriptions', component: PrescriptionView},
    {path: "/prescription/edit/:id", component: EditPrescription},
]

const router = new VueRouter({
    routes
})


new Vue({
    render: h => h(AppView),
    store: store,
    router
}).$mount("#app")
