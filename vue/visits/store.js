import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

import visitSymptoms from './store_modules/visit_symptoms';

/*
* -------------------------------------------------------------------------
* MAIN STORE
* -------------------------------------------------------------------------
* */

export default new Vuex.Store({

    modules: {
        visitSymptoms: visitSymptoms
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

        }

    }

});
