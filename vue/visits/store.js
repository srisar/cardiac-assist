import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

import visitSymptoms from './store_modules/visit_symptoms';
import differentialDiagnosis from './store_modules/differential_diagnosis';
import visitInvestigations from "./store_modules/visit_investigations";

/*
* -------------------------------------------------------------------------
* MAIN STORE
* -------------------------------------------------------------------------
* */

export default new Vuex.Store({

    modules: {
        visitSymptoms        : visitSymptoms,
        differentialDiagnosis: differentialDiagnosis,
        visitInvestigations  : visitInvestigations,
    },

    state: {

        visit: {},

    },

    mutations: {
        updateVisit(state, payload) {
            state.visit = payload;
        }
    },

    getters: {
        getVisit: state => {
            return state.visit;
        }
    },

    actions: {

        /*
        * Fetch visit details
        * */
        fetchVisit({ commit }, id) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visits.php`, {
                    id: id
                }).done(r => {

                    commit('updateVisit', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                })

            });

        },

        /*
        * Update visit details
        * */
        updateVisit({ commit }, visit) {
            return new Promise((resolve, reject) => {


                $.post(`${getSiteURL()}/api/update/visit/visit.php`, visit)
                    .done(r => {
                        resolve(r);
                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        visitSetAsComplete({ commit, }, { visit, status }) {

            return new Promise(((resolve, reject) => {

                const params = {
                    id    : visit.id,
                    status: status,
                }

                $.post(`${getSiteURL()}/api/update/visit/visit-status.php`, params)
                    .done(r => {
                        resolve();
                    })
                    .fail(e => {
                        reject(e);
                    });

            }));
        },


    }

});
