/*
* Visit Diagnosis
* */

export default {
    state: {

        visitDiagnosisList: [],

    },
    /* *** STATE *** */

    mutations: {

        setVisitDiagnosisList(state, payload) {
            state.visitDiagnosisList = payload;
        },


    },
    /* *** MUTATIONS *** */

    getters: {

        getVisitDiagnosisList(state) {
            return state.visitDiagnosisList;
        },

    },
    /* *** GETTERS *** */

    actions: {

        /*
       * Fetch all visit diagnoses
       * */

        async diagnoses_fetchAll(context, visitId) {


            try {

                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-diagnosis.php`, {visit_id: visitId});
                context.commit("setVisitDiagnosisList", response.data);

            } catch (e) {
                throw e;
            }

        },


        /*
        * Add visit diagnosis
        * */

        async diagnoses_add(context, params) {
            try {

                await $.get(`${getSiteURL()}/api/save/visit/visit-diagnosis.php`, params);

            } catch (e) {
                throw e;
            }

        },


        /*
        * Delete visit diagnosis
        * */

        async diagnoses_delete(context, id) {

            try {

                await $.get(`${getSiteURL()}/api/delete/visit/visit-diagnosis.php`, {id: id,});

            } catch (e) {
                throw e;
            }

        },

        /* update */
        async diagnoses_update(context, params) {

            try {
                await $.get(`${getSiteURL()}/api/update/visit/visit-diagnosis.php`, params);
            } catch (e) {
                throw e;
            }

        },

    },
    /* *** ACTIONS *** */
};
