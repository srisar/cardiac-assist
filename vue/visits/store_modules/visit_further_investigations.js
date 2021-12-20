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
            let response = await $.get(`${getSiteURL()}/api/get/visit/visit-further-investigations.php`, {visit_id: visitId});
            context.commit('setFurtherInvestigationsList', response['data']);
        },

        /* fetch */
        async furtherInvestigations_fetch(context, id) {
            let response = await $.get(`${getSiteURL()}/api/get/visit/visit-further-investigations.php`, {id: id});
            context.commit('setSelectedFurtherInvestigation', response['data']);
        },

        /* add */
        async furtherInvestigations_add(context, params) {
            await $.post(`${getSiteURL()}/api/save/visit/visit-further-investigation.php`, params);
        },

        /* update */
        async furtherInvestigations_update(context, params) {
            await $.post(`${getSiteURL()}/api/update/visit/visit-further-investigation.php`, params);
        },

        /* delete */
        async furtherInvestigations_delete(context, id) {
            await $.post(`${getSiteURL()}/api/delete/visit/visit-further-investigation.php`, {id: id});
        },

        /* search all symptoms */
        async furtherInvestigations_search( context, query ) {
            const response = await $.get( `${ getSiteURL() }/api/search/symptoms.php`, { query: query } );
            return response.data;
        },

        /**
         *
         * @param context
         * @param params [symptom_name, description(optional)]
         */
        async furtherInvestigations_addInvestigation( context, params ) {
            return $.post( `${ getSiteURL() }/api/save/investigation.php`, params );
        },


    },

};
