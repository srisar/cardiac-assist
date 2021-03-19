/*
* Visit Diagnosis
* */

export default {
    state: {

        visitDiagnosisList: [],

    },
    /* *** STATE *** */

    mutations: {

        updateVisitDiagnosisList(state, payload) {
            state.visitDiagnosisList = payload;
        },


    },
    /* *** MUTATIONS *** */

    getters: {

        getVisitDiagnosisList: state => {
            return state.visitDiagnosisList;
        },

    },
    /* *** GETTERS *** */

    actions: {

        /*
       * Fetch all visit diagnoses
       * */
        fetchVisitDiagnosis: function ({commit}, visitId) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visit-diagnosis.php`, {
                    visit_id: visitId
                }).done(r => {

                    commit('updateVisitDiagnosisList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },


        /*
        * Add visit diagnosis
        * */
        addVisitDiagnosis: function ({commit, dispatch, rootGetters}, visitDiagnosis) {
            return new Promise((resolve, reject) => {

                const visit_id = rootGetters.getVisit.id;
                const disease_id = visitDiagnosis.disease.id;
                const remarks = visitDiagnosis.remarks;

                $.get(`${getSiteURL()}/api/save/visit/visit-diagnosis.php`, {
                    visit_id: visit_id,
                    disease_id: disease_id,
                    remarks: remarks
                }).done(r => {

                    dispatch('fetchVisitDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        /*
        * Delete visit diagnosis
        * */
        deleteVisitDiagnosis: function ({commit, dispatch, rootGetters}, visitDiagnosis) {
            return new Promise((resolve, reject) => {

                const id = visitDiagnosis.id;

                $.get(`${getSiteURL()}/api/delete/visit/visit-diagnosis.php`, {
                    id: id,
                }).done(r => {

                    const visit_id = rootGetters.getVisit.id;
                    dispatch('fetchVisitDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        updateVisitDiagnosis: function ({commit, dispatch, rootGetters}, visitDiagnosis) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: visitDiagnosis.id,
                    remarks: visitDiagnosis.remarks,
                };

                $.get(`${getSiteURL()}/api/update/visit/visit-diagnosis.php`, {
                    id: params.id,
                    remarks: params.remarks
                }).done(() => {

                    const visit_id = rootGetters.getVisit.id;
                    dispatch('fetchVisitDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

    },
    /* *** ACTIONS *** */
};
