/*
* Visit Symptoms
* */

export default {
    state: {

        symptomsList: [],

        visitSymptomsList: [],

    },

    mutations: {

        setSymptomsList(state, payload) {
            state.symptomsList = payload;
        },

        setVisitSymptomsList(state, payload) {
            state.visitSymptomsList = payload;
        },

    },

    getters: {

        getVisitSymptomsList(state) {
            return state.visitSymptomsList;
        },

        getSymptomsList(state) {
            return state.symptomsList;
        },

    },

    actions: {

        /* fetch all visit symptoms */
        async symptoms_fetchAll(context, visitId) {
            try {

                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-symptoms.php`, {visit_id: visitId});
                context.commit("setVisitSymptomsList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* fetch all available symptoms */
        async symptoms_fetchAllSymptoms(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/symptoms.php`);
                context.commit("setSymptomsList", response.data);

            } catch (e) {
                throw e;
            }
        },

        /* add */
        async symptoms_add(context, params) {

            try {

                await $.get(`${getSiteURL()}/api/save/visit/visit-symptom.php`, params);

            } catch (e) {
                throw e;
            }

        },

        /* delete */
        async symptoms_delete(context, id) {

            try {

                await $.get(`${getSiteURL()}/api/delete/visit/visit-symptom.php`, {id: id});

            } catch (e) {
                throw e;
            }

        },


    }
};
