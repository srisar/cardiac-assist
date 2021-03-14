/*
* Visit Symptoms
* */

export default {
    state: {

        symptomsList: [],

        visitSymptomsList: [],

        addVisitSymptom: {
            showModal: false,
        }
    },

    mutations: {

        updateSymptomsList(state, payload) {
            state.symptomsList = payload;
        },

        updateVisitSymptomsList(state, payload) {
            state.visitSymptomsList = payload;
        },

        setAddModalVisible(state, payload) {
            state.addVisitSymptom.showModal = payload;
        }

    },

    getters: {

        getVisitSymptomsList: state => {
            return state.visitSymptomsList;
        },

        getModalVisibleState: state => {
            return state.addVisitSymptom.showModal;
        },

        getSymptomsList: state => {
            return state.symptomsList;
        }
    },

    actions: {

        /*
        * Fetch all visit-symptoms
        * */
        fetchVisitSymptoms: function ({commit}, visitId) {
            return new Promise((resolve, reject) => {

                const params = {
                    visit_id: visitId
                }

                $.get(`${getSiteURL()}/api/get/visit/visit-symptoms.php`, params)
                    .done(r => {

                        commit('updateVisitSymptomsList', r.data);
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        /*
        * Fetch all symptoms for the select dropdown
        * */
        fetchSymptoms: function ({commit}) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/symptoms.php`)
                    .done(r => {

                        commit('updateSymptomsList', r.data);
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        addVisitSymptom: function ({commit, dispatch, rootGetters}, symptom) {
            return new Promise((resolve, reject) => {

                const params = {
                    visit_id: rootGetters.getVisit.id,
                    symptom_id: symptom.id,
                }

                $.get(`${getSiteURL()}/api/save/visit/visit-symptom.php`, params)
                    .done(r => {

                        dispatch('fetchVisitSymptoms', params.visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        deleteVisitSymptom: function ({commit, dispatch, rootGetters}, visitSymptom) {
            return new Promise((resolve, reject) => {

                const params = {
                    visit_id: rootGetters.getVisit.id,
                    id: visitSymptom.id,
                }

                $.get(`${getSiteURL()}/api/delete/visit/visit-symptom.php`, params)
                    .done(r => {

                        dispatch('fetchVisitSymptoms', params.visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        }

    }
};
