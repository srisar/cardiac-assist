/*
* Visit Diagnosis
* */

export const visitProblems = {
    state: {
        visitProblemsList: [],
        problems: [],
    },

    getters: {

        getVisitProblemsList( state ) {
            return state.visitProblemsList;
        },

        getProblems( state ) {
            return state.problems;
        },

    },

    actions: {

        async visitProblems_fetchAllProblems( context ) {
            const response = await $.get( `${ getSiteURL() }/api/get/problems.php` );
            context.state.problems = response.data;
        },

        /* fetch all */
        async visitProblems_fetchAll( context, visitId ) {
            const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-problems.php`, { visit_id: visitId } );
            context.state.visitProblemsList = response.data;
        },


        /* add */
        async visitProblems_add( context, params ) {
            await $.get( `${ getSiteURL() }/api/save/visit/visit-problem.php`, params );
        },

        /* update */
        async visitProblems_update( context, params ) {
            await $.get( `${ getSiteURL() }/api/update/visit/visit-problem.php`, params );
        },

        /* delete */
        async visitProblems_delete( context, id ) {
            await $.get( `${ getSiteURL() }/api/delete/visit/visit-problem.php`, { id: id } );
        },



        /* search all symptoms */
        async visitProblems_search( context, query ) {
            const response = await $.get( `${ getSiteURL() }/api/search/problems.php`, { query: query } );
            return response.data;
        },

        /**
         *
         * @param context
         * @param params [symptom_name, description(optional)]
         */
        async visitProblems_addProblem( context, params ) {
            return $.post( `${ getSiteURL() }/api/save/problem.php`, params );
        },


    },
    /* *** ACTIONS *** */
};
