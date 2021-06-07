export const visitPrescriptions = {

    state: {

        visitPrescriptions: [],
        selectedPrescription: {},

        drugsSearchResult: [],

    },

    getters: {

        getVisitPrescriptions(state) {
            return state.visitPrescriptions;
        },

        getDrugsSearchResult(state) {
            return state.drugsSearchResult;
        },

        getSelectedPrescription(state) {
            return state.selectedPrescription;
        }

    },

    mutations: {

        setVisitPrescriptions(state, data) {
            state.visitPrescriptions = data;
        },

    },

    actions: {

        /* fetch all */
        async prescriptions_fetchAll(context, visit_id) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-prescriptions.php`, {visit_id: visit_id});
                context.commit("setVisitPrescriptions", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* fetch */
        async prescriptions_fetch(context, id) {

            try {
                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-prescriptions.php`, {id: id});
                context.state.selectedPrescription = response.data;

            } catch (e) {
                throw e;
            }
        },

        /* add prescription */
        async prescription_add(context, params) {
            try {

                await $.post(`${getSiteURL()}/api/save/visit/visit-prescription.php`, params);

            } catch (e) {

            }
        },

        /* update prescription */
        async prescriptions_update(context, params) {
            try {

                await $.post(`${getSiteURL()}/api/update/visit/visit-prescription.php`, params);

            } catch (e) {

            }
        },

        /* delete prescription */
        async prescriptions_delete(context, params) {

            /*
            * params = {id}
            * */

            try {
                await $.post(`${getSiteURL()}/api/delete/visit/visit-prescription.php`, params);
            } catch (e) {
                throw e;
            }

        },

        /* search drugs */
        async prescriptions_searchDrugs(context, query) {

            try {

                const response = await $.get(`${getSiteURL()}/api/search/drugs.php?query=${query}`);
                context.state.drugsSearchResult = response.drugs;

            } catch (e) {
                throw e;
            }
        },

        /* update prescription item */
        async prescriptions_updatePrescriptionItem(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/update/visit/visit-prescription-item.php`, params);

            } catch (e) {
                throw e;
            }

        },

        /* add prescription item */
        async prescriptions_addPrescriptionItem(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/save/visit/visit-prescription-item.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* delete prescription item */
        async prescriptions_deletePrescriptionItem(context, params) {
            try {

                await $.post(`${getSiteURL()}/api/delete/visit/visit-prescription-item.php`, params);

            } catch (e) {
                throw e;
            }
        },


    },

};
