export const visitPrescriptions = {

    state: {

        visitPrescriptions: [],
        selectedPrescription: {},

        drugsSearchResult: [],

    },

    getters: {

        getVisitPrescriptions( state ) {
            return state.visitPrescriptions;
        },

        getDrugsSearchResult( state ) {
            return state.drugsSearchResult;
        },

        getSelectedPrescription( state ) {
            return state.selectedPrescription;
        },

    },

    mutations: {

        setVisitPrescriptions( state, data ) {
            state.visitPrescriptions = data;
        },

    },

    actions: {

        /* fetch all */
        async prescriptions_fetchAll( context, visit_id ) {
            const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-prescriptions.php`, { visit_id: visit_id } );
            context.commit( 'setVisitPrescriptions', response[ 'data' ] );

        },

        /* fetch */
        async prescriptions_fetch( context, id ) {
            const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-prescriptions.php`, { id: id } );
            context.state.selectedPrescription = response[ 'data' ];
        },

        /* add prescription */
        async prescription_add( context, params ) {
            await $.post( `${ getSiteURL() }/api/save/visit/visit-prescription.php`, params );
        },

        /* update prescription */
        async prescriptions_update( context, params ) {
            await $.post( `${ getSiteURL() }/api/update/visit/visit-prescription.php`, params );
        },

        /* delete prescription */
        async prescriptions_delete( context, params ) {

            await $.post( `${ getSiteURL() }/api/delete/visit/visit-prescription.php`, params );

        },

        /* search drugs */
        async prescriptions_searchDrugs( context, query ) {

            const response = await $.get( `${ getSiteURL() }/api/search/drugs.php?query=${ query }` );
            return response[ 'data' ];
        },

        async prescriptions_saveDrug( context, params ) {
            await $.post( `${ getSiteURL() }/api/save/drug.php`, params );
        },

        /* update prescription item */
        async prescriptions_updatePrescriptionItem( context, params ) {

            await $.post( `${ getSiteURL() }/api/update/visit/visit-prescription-item.php`, params );

        },

        /* add prescription item */
        async prescriptions_addPrescriptionItem( context, params ) {
            await $.post( `${ getSiteURL() }/api/save/visit/visit-prescription-item.php`, params );
        },

        /* delete prescription item */
        async prescriptions_deletePrescriptionItem( context, params ) {
            await $.post( `${ getSiteURL() }/api/delete/visit/visit-prescription-item.php`, params );
        },


    },

};
