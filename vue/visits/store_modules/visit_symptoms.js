/*
* Visit Symptoms
* */

export default {
    state: {

        symptomsList: [],

        visitSymptomsList: [],

    },

    mutations: {

        setSymptomsList( state, payload ) {
            state.symptomsList = payload;
        },

        setVisitSymptomsList( state, payload ) {
            state.visitSymptomsList = payload;
        },

    },

    getters: {

        getVisitSymptomsList( state ) {
            return state.visitSymptomsList;
        },

        getSymptomsList( state ) {
            return state.symptomsList;
        },

    },

    actions: {

        /* fetch all visit symptoms */
        async visitSymptoms_fetchAll( context, visitId ) {
            try {

                const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-symptoms.php`, { visit_id: visitId } );
                context.commit( 'setVisitSymptomsList', response.data );

            } catch ( e ) {
                throw e;
            }

        },

        /* fetch all available symptoms */
        async visitSymptoms_fetchAllSymptoms( context ) {

            try {

                const response = await $.get( `${ getSiteURL() }/api/get/symptoms.php` );
                context.commit( 'setSymptomsList', response.data );

            } catch ( e ) {
                throw e;
            }
        },

        /* add */
        async visitSymptoms_add( context, params ) {
            return $.get( `${ getSiteURL() }/api/save/visit/visit-symptom.php`, params );
        },

        /* delete */
        async visitSymptoms_delete( context, id ) {
            return $.get( `${ getSiteURL() }/api/delete/visit/visit-symptom.php`, { id: id } );
        },

        /* search all symptoms */
        async visitSymptoms_search( context, query ) {
            const response = await $.get( `${ getSiteURL() }/api/search/symptoms.php`, { query: query } );
            return response.data;
        },

        /**
         *
         * @param context
         * @param params [symptom_name, description(optional)]
         */
        async visitSymptoms_addSymptom( context, params ) {
            return $.post( `${ getSiteURL() }/api/save/symptom.php`, params );
        },


    },
};
