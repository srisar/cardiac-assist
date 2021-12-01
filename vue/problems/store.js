import Vue from 'vue';
import Vuex from 'vuex';

Vue.use( Vuex );

export const store = new Vuex.Store( {

    state: {

        problems: [],
        selectedProblem: {},

    },
    getters: {
        getProblems( state ) {
            return state.problems;
        },

        getSelectedProblem( state ) {
            return state.selectedProblem;
        },

    },

    mutations: {},

    actions: {


        async problems_fetch( context, id ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/problems.php`, { id: id } );
                context.state.selectedProblem = response.data;
            } catch ( e ) {
                throw e;
            }
        }, /* fetch all */

        async problems_fetchAll( context ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/problems.php` );
                context.state.problems = response.data;
            } catch ( e ) {
                throw e;
            }
        }, /* fetch all */


        async problem_save( context, params ) {
            try {
                await $.post( `${ getSiteURL() }/api/save/problem.php`, params );
            } catch ( e ) {
                throw e;
            }
        }, /* save */

        async problem_update( context, params ) {
            return $.post( `${ getSiteURL() }/api/update/problem.php`, params );
        }, /* update */


    },

} );
