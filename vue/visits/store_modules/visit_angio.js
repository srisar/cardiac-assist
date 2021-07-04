export const visitAngio = {
    state: {
        visitAngio: {},
    },

    getters: {

        getVisitAngio( state ) {
            return state.visitAngio;
        },

    },

    actions: {

        async visitAngio_fetch( context, visitId ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-angio.php`, {visit_id: visitId} );
                context.state.visitAngio = response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async visitAngio_update( context, params ) {
            try {
                await $.get( `${ getSiteURL() }/api/update/visit/visit-angio.php`, params );
            } catch ( e ) {
                throw e;
            }
        },

    },
    /* -- actions -- */
};
