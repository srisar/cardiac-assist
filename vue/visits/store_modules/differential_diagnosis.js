/*
* Differential Diagnosis
* */

export default {
    state: {

        differentialDiagnosisList: [],

        diseasesList: [],


    },

    mutations: {

        setDifferentialDiagnosisList(state, payload) {
            state.differentialDiagnosisList = payload;
        },

        setDiseasesList(state, payload) {
            state.diseasesList = payload;
        },

    },

    getters: {

        getDiseasesList(state) {
            return state.diseasesList;
        },

        getDifferentialDiagnosisList(state) {
            return state.differentialDiagnosisList;
        },


    },

    actions: {

        /*
        * Fetch all differential diagnoses
        * */
        async diffDiagnoses_fetchAll(context, visitId) {


            try {

                const response = await $.get(`${getSiteURL()}/api/get/diff-diagnosis.php`, {visit_id: visitId});
                context.commit("setDifferentialDiagnosisList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /*
        * Fetch all diseases
        * */
        async diffDiagnoses_fetchAllDiseases(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/diseases.php`);
                context.commit("setDiseasesList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /*
        * Add diff. diagnosis
        * */
        async diffDiagnoses_add(context, params) {
            try {

                await $.get(`${getSiteURL()}/api/save/diff-diagnosis.php`, params);

            } catch (e) {
                throw e;
            }

        },

        /*
        * Delete diff. diagnosis
        * */
        async diffDiagnoses_delete(context, id) {


            try {

                await $.get(`${getSiteURL()}/api/delete/diff-diagnosis.php`, {id: id,});

            } catch (e) {
                throw e;
            }

        },

        /* update */
        async diffDiagnoses_update(context, params) {

            try {
                await $.get(`${getSiteURL()}/api/update/diff-diagnosis.php`, params);
            } catch (e) {
                throw e;
            }

        },

    }
};
