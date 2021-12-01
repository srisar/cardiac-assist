/*
* Differential Diagnosis
* */

export default {
    state: {

        differentialDiagnosisList: [],

        diseasesList: [],


    },

    mutations: {

        setDifferentialDiagnosisList( state, payload ) {
            state.differentialDiagnosisList = payload;
        },

        setDiseasesList( state, payload ) {
            state.diseasesList = payload;
        },

    },

    getters: {

        getDiseasesList( state ) {
            return state.diseasesList;
        },

        getDifferentialDiagnosisList( state ) {
            return state.differentialDiagnosisList;
        },


    },

    actions: {

        /*
        * Fetch all differential diagnoses
        * */
        async diffDiagnoses_fetchAll( context, visitId ) {


            try {

                const response = await $.get( `${ getSiteURL() }/api/get/diff-diagnosis.php`, { visit_id: visitId } );
                context.commit( 'setDifferentialDiagnosisList', response.data );

            } catch ( e ) {
                throw e;
            }

        },

        /*
        * Fetch all diseases
        * */
        async diffDiagnoses_fetchAllDiseases( context ) {

            try {

                const response = await $.get( `${ getSiteURL() }/api/get/diseases.php` );
                context.commit( 'setDiseasesList', response.data );

            } catch ( e ) {
                throw e;
            }

        },

        /*
        * Add diff. diagnosis
        * */
        async diffDiagnoses_add( context, params ) {
            return $.get( `${ getSiteURL() }/api/save/diff-diagnosis.php`, params );

        },

        /*
        * Delete diff. diagnosis
        * */
        async diffDiagnoses_delete( context, id ) {

            return $.get( `${ getSiteURL() }/api/delete/diff-diagnosis.php`, { id: id } );

        },

        /* update */
        async diffDiagnoses_update( context, params ) {

            return $.get( `${ getSiteURL() }/api/update/diff-diagnosis.php`, params );
        },

        async diffDiagnoses_searchDiseases(context, query){
            const response = await $.get( `${ getSiteURL() }/api/search/diseases.php`, { query: query } );
            return response.data;
        },

        async diffDiagnoses_addDisease( context, params ) {
            return $.post( `${ getSiteURL() }/api/save/disease.php`, params );
        },

    },
};
