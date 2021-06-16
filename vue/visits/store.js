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
    },

    state() {
        return {
            visit: {},
            visitId: -1,

            view: {
                hasSidebar: true,
            }

        };
    }, /* state */

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


    }, /* mutations */

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


        /*
        * Fetch visit details
        * */
        fetchVisit({commit}, id) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visits.php`, {
                    id: id
                }).done(r => {

                    if (r.data == null) {
                        reject("empty")
                    } else {
                        commit("updateVisit", r.data)
                        resolve()
                    }

                }).fail(e => {
                    reject(e)
                })

            });

        },

        /*
        * Update visit details
        * */
        updateVisit({commit}, visit) {
            return new Promise((resolve, reject) => {


                $.post(`${getSiteURL()}/api/update/visit/visit.php`, visit)
                    .done(r => {
                        resolve(r)
                    })
                    .fail(e => {
                        reject(e)
                    });

            });
        },

        visitSetAsComplete({commit,}, {visit, status}) {

            return new Promise(((resolve, reject) => {

                const params = {
                    id: visit.id,
                    status: status,
                }

                $.post(`${getSiteURL()}/api/update/visit/visit-status.php`, params)
                    .done(r => {
                        resolve()
                    })
                    .fail(e => {
                        reject(e)
                    });

            }))
        },

    },
    /* *** ACTIONS *** */

})
