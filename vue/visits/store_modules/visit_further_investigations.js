export const visitFurtherInvestigation = {

    state: {

        selectedFurtherInvestigation: {},
        furtherInvestigationsList: []

    },

    getters: {

        getSelectedFurtherInvestigation(state) {
            return state.selectedFurtherInvestigation;
        },

        getFurtherInvestigationsList(state) {
            return state.furtherInvestigationsList;
        },

    },

    mutations: {

        setSelectedFurtherInvestigation(state, data) {
            state.selectedFurtherInvestigation = data;
        },

        setFurtherInvestigationsList(state, data) {
            state.furtherInvestigationsList = data;
        }

    },

    actions: {

        /* fetch all */
        async furtherInvestigations_fetchAll(context, visitId) {
            try {

                let response = await $.get(`${getSiteURL()}/api/get/visit/visit-further-investigations.php`, {visit_id: visitId});
                context.commit("setFurtherInvestigationsList", response.data);

            } catch (e) {
                throw e;
            }
        },

        /* fetch */
        async furtherInvestigations_fetch(context, id) {
            try {

                let response = await $.get(`${getSiteURL()}/api/get/visit/visit-further-investigations.php`, {id: id});
                context.commit("setSelectedFurtherInvestigation", response.data);
            } catch (e) {
                throw e;

            }
        },

        /* add */
        async furtherInvestigations_add(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/save/visit/visit-further-investigation.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* update */
        async furtherInvestigations_update(context, params) {
            try {

                let response = await $.post(`${getSiteURL()}/api/update/visit/visit-further-investigation.php`, params);

            } catch (e) {
                throw e;

            }
        },

        /* delete */
        async furtherInvestigations_delete(context, id) {
            try {

                let response = await $.post(`${getSiteURL()}/api/delete/visit/visit-further-investigation.php`, {id: id});

            } catch (e) {
                throw e;

            }
        },


    },

};
