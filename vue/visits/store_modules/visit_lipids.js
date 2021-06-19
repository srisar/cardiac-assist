export const visitLipids = {
    state: {
        visitLipids: {},
    },

    getters: {

        getVisitLipids(state) {
            return state.visitLipids;
        },

    },

    actions: {

        /* fetch all */
        async visitLipids_fetchAll(context, visitId) {

            try {
                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-lipids.php`, {visit_id: visitId});
                context.state.visitLipids = response.data;

            } catch (e) {
                throw e;
            }
        },


        /* update */
        async visitLipids_update(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/update/visit/visit-lipids.php`, params);
            } catch (e) {
                throw e;
            }
        },

    },
    /* *** ACTIONS *** */
};
