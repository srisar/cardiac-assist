export const visitSpecialEcg = {
    state: {
        visitECG: {},
    },

    getters: {

        getVisitECG( state ) {
            return state.visitECG;
        },

    },

    actions: {

        /* fetch */
        async visitECG_fetch( context, visitId ) {
            const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-ecg.php`, { visit_id: visitId } );
            context.state.visitECG = response['data'];
        },


        /* update */
        async visitECG_update( context, params ) {
            await $.post( `${ getSiteURL() }/api/update/visit/visit-ecg.php`, params );
        },

    },
    /* *** ACTIONS *** */
};
