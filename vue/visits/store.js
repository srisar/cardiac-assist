import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

const visitSymptomsStore = {
    state: {
        visitSymptomsList: [],
    },

    mutations: {
        updateVisitSymptomsList(state, payload) {
            state.visitSymptomsList = payload;
        }
    },

    getters: {
        getVisitSymptomsList: state => {
            return state.visitSymptomsList;
        }
    },

    actions: {

        fetchVisitSymptoms: function ({commit}, visitId) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit-symptoms.php`, {
                    visit_id: visitId
                }).done(r => {

                    commit('updateVisitSymptomsList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        }

    }
};

export default new Vuex.Store({

    modules: {
        visitSymptoms: visitSymptomsStore
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
