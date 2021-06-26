/*
* Investigations
* */

export const visitReferralLetters = {
    state: {

        letterModels: [],
        visitLetters: [],
        selectedVisitLetter: {},

    },

    getters: {
        getLetterModels( state ) {
            return state.letterModels;
        },

        getVisitLetters( state ) {
            return state.visitLetters;
        },

        getSelectedVisitLetter( state ) {
            return state.selectedVisitLetter;
        }
    },

    mutations: {},

    actions: {

        async visitLetters_fetchAllModels( context ) {
            try {

                const response = await $.get( `${ getSiteURL() }/api/get/referral-letters.php` );
                context.state.letterModels = response.data;

            } catch ( e ) {
                throw e;
            }
        },

        async visitLetters_fetchAll( context, visitId ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-referral-letters.php`, { visit_id: visitId } );
                context.state.visitLetters = response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async visitLetters_fetch( context, id ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-referral-letters.php`, { id: id } );
                context.state.selectedVisitLetter = response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async visitLetters_add( context, params ) {
            try {
                await $.post( `${ getSiteURL() }/api/save/visit/visit-referral-letter.php`, params );
            } catch ( e ) {
                throw e;
            }
        },

        async visitLetters_update( context, params ) {
            try {
                await $.post( `${ getSiteURL() }/api/update/visit/visit-referral-letter.php`, params );
            } catch ( e ) {
                throw e;
            }
        },

        async visitLetters_delete( context, id ) {
            try {
                await $.post( `${ getSiteURL() }/api/delete/visit/visit-referral-letter.php`, { id: id } );
            } catch ( e ) {
                throw e;
            }
        },


    }
};
