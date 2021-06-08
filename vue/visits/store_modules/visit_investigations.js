/*
* Investigations
* */

export default {
    state: {

        visitInvestigationsList: [],
        investigationsList: [],

    },

    mutations: {

        setInvestigationsList: function (state, data) {
            state.investigationsList = data;
        },

        setVisitInvestigationsList: function (state, data) {
            state.visitInvestigationsList = data;
        },

    },

    getters: {
        getInvestigationsList: function (state) {
            return state.investigationsList;
        },

        getVisitInvestigationsList: function (state) {
            return state.visitInvestigationsList;
        }
    },

    actions: {

        /* fetch all available investigations */
        async investigations_fetchAllAvailableInvestigation(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/investigations.php`);
                context.commit("setInvestigationsList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* fetch all visit investigations */
        async visitInvestigations_fetchAll(context, visitId) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-investigations.php`, {visit_id: visitId});
                context.commit("setVisitInvestigationsList", response.data);
            } catch (e) {
                throw e;
            }

        },

        /* add */
        async visitInvestigations_add(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/save/visit/visit-investigation.php`, params);
            } catch (e) {
                throw e;
            }

        },

        /* delete */
        async visitInvestigations_delete(context, id) {
            try {
                await $.post(`${getSiteURL()}/api/delete/visit/visit-investigation.php`, {id: id});
            } catch (e) {
                throw e;
            }
        },

        /* update */
        async visitInvestigations_update(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/update/visit/visit-investigation.php`, params)
            } catch (e) {
                throw e;
            }
        },

    }
};
