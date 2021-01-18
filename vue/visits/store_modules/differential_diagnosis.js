/*
* Differential Diagnosis
* */

export default {
    state: {

        differentialDiagnosisList: [],

        diseasesList: [],


    },

    mutations: {

        updateDifferentialDiagnosisList(state, payload) {
            state.differentialDiagnosisList = payload;
        },

        updateDiseasesList(state, payload) {
            state.diseasesList = payload;
        },

    },

    getters: {

        diseasesList: state => {
            return state.diseasesList;
        },

        differentialDiagnosisList: state => {
            return state.differentialDiagnosisList;
        },


    },

    actions: {

        /*
        * Fetch all diseases
        * */
        fetchDifferentialDiagnosis: function ({commit}, visitId) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/diff-diagnosis.php`, {
                    visit_id: visitId
                }).done(r => {

                    commit('updateDifferentialDiagnosisList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        /*
        * Fetch all diseases
        * */
        fetchDiseases: function ({commit}) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/diseases.php`)
                    .done(r => {

                        commit('updateDiseasesList', r.data);
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        /*
        * Add diff. diagnosis
        * */
        addDifferentialDiagnosis: function ({commit, dispatch, rootGetters}, diffDiagnosis) {
            return new Promise((resolve, reject) => {

                const visit_id = rootGetters.getVisit.id;
                const disease_id = diffDiagnosis.disease.id;
                const remarks = diffDiagnosis.remarks;

                $.get(`${getSiteURL()}/api/save/diff-diagnosis.php`, {
                    visit_id: visit_id,
                    disease_id: disease_id,
                    remarks: remarks
                }).done(r => {

                    dispatch('fetchDifferentialDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        /*
        * Delete diff. diagnosis
        * */
        deleteDiffDiagnosis: function ({commit, dispatch, rootGetters}, diffDiagnosis) {
            return new Promise((resolve, reject) => {

                const id = diffDiagnosis.id;

                $.get(`${getSiteURL()}/api/delete/diff-diagnosis.php`, {
                    id: id,
                }).done(r => {

                    const visit_id = rootGetters.getVisit.id;
                    dispatch('fetchDifferentialDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        updateDiffDiagnosis: function ({commit, dispatch, rootGetters}, diffDiagnosis) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: diffDiagnosis.id,
                    remarks: diffDiagnosis.remarks,
                };

                $.get(`${getSiteURL()}/api/update/diff-diagnosis.php`, {
                    id: params.id,
                    remarks: params.remarks
                }).done(r => {

                    const visit_id = rootGetters.getVisit.id;
                    dispatch('fetchDifferentialDiagnosis', visit_id);

                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        }

    }
};
