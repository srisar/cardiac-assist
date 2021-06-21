import Vuex from "vuex";
import Vue from "vue";
import visitSymptoms from "./store_modules/visit_symptoms";
import differentialDiagnosis from "./store_modules/differential_diagnosis";
import visitInvestigations from "./store_modules/visit_investigations";
import visitDiagnosis from "./store_modules/visit_diagnosis";
import visitEchoValues from "./store_modules/visit_echo_values";
import {visitPrescriptions} from "./store_modules/visit_prescriptions";
import {visitFurtherInvestigation} from "./store_modules/visit_further_investigations";
import {visitReferralLetters} from "./store_modules/visit_referral_letters";
import {visitProblems} from "./store_modules/visit_problems";
import {visitLipids} from "./store_modules/visit_lipids";
import {visitSpecialEcg} from "./store_modules/special_ecg";
import {visitSpecialEcho} from "./store_modules/special_echo";

Vue.use(Vuex);


export default new Vuex.Store({

    modules: {
        visitSymptoms: visitSymptoms,
        differentialDiagnosis: differentialDiagnosis,
        visitInvestigations: visitInvestigations,
        visitDiagnosis: visitDiagnosis,
        visitEchoValues: visitEchoValues,
        visitPrescriptions: visitPrescriptions,
        visitFurtherInvestigation: visitFurtherInvestigation,
        visitReferralLetters: visitReferralLetters,
        visitProblems: visitProblems,
        visitLipids: visitLipids,
        visitECG: visitSpecialEcg,
        visitEcho: visitSpecialEcho,

    },

    state() {
        return {
            visit: {},
            visitId: -1,

            view: {
                hasSidebar: true,
            }

        };
    },
    /* -- state -- */

    mutations: {
        updateVisit(state, payload) {
            state.visit = payload
        },

        updateVisitId(state, payload) {
            state.visitId = payload
        },

        hasSidebar(state, value) {
            state.view.hasSidebar = value;
        },


    },
    /* -- mutations -- */

    getters: {

        getPatient(state) {
            return state.visit.patient;
        },

        getVisit(state) {
            return state.visit
        },

        getVisitId(state) {
            return state.visitId
        },

    }, /* getters */

    actions: {

        async hideSidebar(context) {
            context.commit("hasSidebar", false);
        },


        /* fetch visit details */
        async visit_fetch(context, id) {

            try {
                let response = await $.get(`${getSiteURL()}/api/get/visit/visits.php`, {id: id});
                context.commit("updateVisit", response.data);
            } catch (e) {
                throw e;
            }
        },

        /* update visit details */
        async visit_update(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/update/visit/visit.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* visit set as complete */
        async visit_setStatus(context, params) {

            /*
            * params: visit_id, status
            * */

            try {
                $.post(`${getSiteURL()}/api/update/visit/visit-status.php`, params);
            } catch (e) {
                throw e;
            }
        },

    },
    /* -- actions -- */

})
