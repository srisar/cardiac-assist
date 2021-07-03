import Vue from 'vue';
import Vuex from 'vuex';

Vue.use( Vuex );


export default new Vuex.Store( {

    state: {
        diseasesList: [],
        selectedDisease: null,
    },

    mutations: {},

    getters: {
        getDiseasesList( state ) {
            return state.diseasesList;
        },

        getSelectedDisease( state ) {
            return state.selectedDisease;
        },

    },

    actions: {


        async diseases_fetchAll( context ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/diseases.php` );
                context.state.diseasesList = response.data;
            } catch ( e ) {
                throw e;
            }
        },/* fetch all */

        async diseases_fetch( context, id ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/diseases.php`, { id: id } );
                context.state.selectedDisease = response.data;
            } catch ( e ) {
                throw e;
            }
        },/* fetch */

        async diseases_add( context, params ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/save/disease.php`, params );
            } catch ( e ) {
                throw e;
            }
        },/* add */

        async diseases_update( context, params ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/update/disease.php`, params );
            } catch ( e ) {
                throw e;
            }
        },/* update */

        async diseases_delete( context, id ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/delete/disease.php`, { id: id } );
            } catch ( e ) {
                throw e;
            }
        },/* delete */


    }

} );
