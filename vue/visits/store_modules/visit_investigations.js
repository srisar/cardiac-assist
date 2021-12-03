/*
* Investigations
* */

export default {
    state: {

        visitInvestigationsList: [],
        investigationsList: [],

    },

    mutations: {

        setInvestigationsList: function ( state, data ) {
            state.investigationsList = data;
        },

        setVisitInvestigationsList: function ( state, data ) {
            state.visitInvestigationsList = data;
        },

    },

    getters: {
        getInvestigationsList: function ( state ) {
            return state.investigationsList;
        },

        getVisitInvestigationsList: function ( state ) {
            return state.visitInvestigationsList;
        },
    },

    actions: {

        /* fetch all available investigations */
        async investigations_fetchAllAvailableInvestigation( context ) {

            const response = await $.get( `${ getSiteURL() }/api/get/investigations.php` );
            context.commit( 'setInvestigationsList', response.data );

        },

        /* fetch all visit investigations */
        async visitInvestigations_fetchAll( context, visitId ) {
            const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-investigations.php`, { visit_id: visitId } );
            context.commit( 'setVisitInvestigationsList', response.data );

        },

        /* add */
        async visitInvestigations_add( context, params ) {

            await $.post( `${ getSiteURL() }/api/save/visit/visit-investigation.php`, params );

        },

        /* delete */
        async visitInvestigations_delete( context, id ) {
            await $.post( `${ getSiteURL() }/api/delete/visit/visit-investigation.php`, { id: id } );
        },

        /* update */
        async visitInvestigations_update( context, params ) {
            await $.post( `${ getSiteURL() }/api/update/visit/visit-investigation.php`, params );
        },

        async visitInvestigations_search( context, query ) {
            const response = await $.get( `${ getSiteURL() }/api/search/investigations.php`, { query: query } );
            return response.data;
        },

        async visitInvestigations_addInvestigation( context, params ) {
            return $.post( `${ getSiteURL() }/api/save/investigation.php`, params );
        },

    },
};
