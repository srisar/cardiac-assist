import Vue from "vue"
import Vuex from "vuex"
import VueRouter from "vue-router";

import store from "./store"
import BasicView from "./views/BasicView";
import DiagnosesView from "./views/diagnoses/DiagnosesView";
import AppView from "./views/AppView";
import EditVisitDetails from "./views/EditVisitDetails";
import VisitECGView from "./views/special-investigations/VisitECGView";
import VisitLipidsView from "./views/special-investigations/VisitLipidsView";
import VisitCoronaryCTView from "./views/special-investigations/VisitCoronaryCTView";
import VisitAngiographyView from "./views/special-investigations/VisitAngiographyView";
import PrescriptionView from "./views/intervention/prescriptions/PrescriptionView";
import EditPrescription from "./views/intervention/prescriptions/EditPrescription";
import FurtherInvestigationsView from "./views/intervention/FurtherInvestigationsView";
import VisitReviewInView from "./views/intervention/VisitReviewInView";
import OtherRemarksView from "./views/intervention/OtherRemarksView";
import ReferralLettersView from "./views/intervention/referral-letters/ReferralLettersView";
import EditReferralLetter from "./views/intervention/referral-letters/EditReferralLetter";
import ReportView from "./views/ReportView";
import BasicReportView from "./views/reports/BasicReportView";
import VisitEchoViewV2 from "./views/special-investigations/VisitEchoViewV2";
import PrintReferralLetter from "./views/intervention/referral-letters/PrintReferralLetter";


Vue.use( Vuex )
Vue.use( VueRouter )


const routes = [
    { path: "", component: BasicView },
    { path: "/diagnoses", component: DiagnosesView },
    { path: "/edit/:id", component: EditVisitDetails },

    { path: "/special/ecg", component: VisitECGView },
    { path: "/special/lipids", component: VisitLipidsView },
    { path: "/special/coronary-ct", component: VisitCoronaryCTView },
    { path: "/special/echo", component: VisitEchoViewV2 },
    { path: "/special/angio", component: VisitAngiographyView },

    {
        path: "/prescriptions",
        component: PrescriptionView,
        children: [
            { path: "edit/:id", component: EditPrescription },
        ],
    },

    { path: "/further-investigations", component: FurtherInvestigationsView },
    { path: "/review-in", component: VisitReviewInView },
    { path: "/other-remarks", component: OtherRemarksView },
    { path: "/referral-letters", component: ReferralLettersView },
    { path: "/referral-letters/edit/:id", component: EditReferralLetter },
    { path: "/referral-letters/print/:id", component: PrintReferralLetter },

    { path: "/reports", component: ReportView },
    { path: "/reports/basic", component: BasicReportView },
]

const router = new VueRouter( {
    routes,
    scrollBehavior( to ) {
        if ( to.hash ) {
            return {
                selector: to.hash,
                behavior: "smooth"
            };
        } else {
            return { x: 0, y: 0, behavior: "smooth" };
        }
    }
} );


router.beforeEach( ( to, from, next ) => {
    store.commit( "hasSidebar", true );
    next();
} );


new Vue( {
    render: h => h( AppView ),
    store: store,
    router
} ).$mount( "#app" );
