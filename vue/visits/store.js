import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

import visitSymptoms from './store_modules/visit_symptoms';
import differentialDiagnosis from './store_modules/differential_diagnosis';
import investigations from "./store_modules/investigations";

/*
* -------------------------------------------------------------------------
* MAIN STORE
* -------------------------------------------------------------------------
* */

export default new Vuex.Store({

    modules: {
        visitSymptoms: visitSymptoms,
        differentialDiagnosis: differentialDiagnosis,
        investigations: investigations,
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
        fetchVisit({commit}, id) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visits.php`, {
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
        updateVisit({commit}, visit) {
            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/update/visit.php`, {
                    id: visit.id,
                    visit_date: visit.visit_date,
                    remarks: visit.remarks
                }).done(r => {

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        }

    }

});
