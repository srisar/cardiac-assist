export const visitSpecialEcg = {
    state: {
        visitECG: {},
    },

    getters: {

        getVisitECG(state) {
            return state.visitECG;
        },

    },

    actions: {

        /* fetch */
        async visitECG_fetch(context, visitId) {

            try {
                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-ecg.php`, {visit_id: visitId});
                context.state.visitECG = response.data;

            } catch (e) {
                throw e;
            }
        },


        /* update */
        async visitECG_update(context, params) {
            try {
                await $.post(`${getSiteURL()}/api/update/visit/visit-ecg.php`, params);
            } catch (e) {
                throw e;
            }
        },

    },
    /* *** ACTIONS *** */
};
