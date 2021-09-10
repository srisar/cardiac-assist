import Vue from 'vue';
import Vuex from 'vuex';
import differentialDiagnosis from './store_modules/differential_diagnosis';
import {visitSpecialEcg} from './store_modules/special_ecg';
import {visitSpecialEcho} from './store_modules/special_echo';
import {visitAngio} from './store_modules/visit_angio';
import visitDiagnosis from './store_modules/visit_diagnosis';
import visitEchoValues from './store_modules/visit_echo_values';
import {visitFurtherInvestigation} from './store_modules/visit_further_investigations';
import visitInvestigations from './store_modules/visit_investigations';
import {visitLipids} from './store_modules/visit_lipids';
import {visitPrescriptions} from './store_modules/visit_prescriptions';
import {visitProblems} from './store_modules/visit_problems';
import {visitReferralLetters} from './store_modules/visit_referral_letters';
import visitSymptoms from './store_modules/visit_symptoms';

Vue.use( Vuex );


export default new Vuex.Store( {

    modules: {
        visitSymptoms: visitSymptoms,
        differentialDiagnosis: differentialDiagnosis,
        visitInvestigations: visitInvestigations,
        visitDiagnosis: visitDiagnosis,
        visitEchoValues: visitEchoValues,
        visitPrescriptions: visitPrescriptions,
        visitFurtherInvestigation: visitFurtherInvestigation,
        visitReferralLetters: visitReferralLetters,
        visitProblems: visitProblems,
        visitLipids: visitLipids,
        visitECG: visitSpecialEcg,
        visitEcho: visitSpecialEcho,
        visitAngio: visitAngio,

    },

    state() {
        return {
            visit: {},
            visitId: -1,

            view: {
                hasSidebar: true,
            },

        };
    },
    /* -- state -- */

    mutations: {
        updateVisit( state, payload ) {
            state.visit = payload;
        },

        updateVisitId( state, payload ) {
            state.visitId = payload;
        },

        hasSidebar( state, value ) {
            state.view.hasSidebar = value;
        },


    },
    /* -- mutations -- */

    getters: {

        getPatient( state ) {
            return state.visit.patient;
        },

        getVisit( state ) {
            return state.visit;
        },

        getVisitId( state ) {
            return state.visitId;
        },

    }, /* getters */

    actions: {

        async hideSidebar( context ) {
            context.commit( 'hasSidebar', false );
        },


        /* fetch visit details */
        async visit_fetch( context, id ) {
            let response = await $.get( `${ getSiteURL() }/api/get/visit/visits.php`, { id: id } );
            context.commit( 'updateVisit', response.data );
        },

        /* update visit details */
        async visit_update( context, params ) {
            await $.post( `${ getSiteURL() }/api/update/visit/visit.php`, params );
        },

        /* visit set as complete */
        async visit_setStatus( context, params ) {

            /*
            * params: visit_id, status
            * */
            $.post( `${ getSiteURL() }/api/update/visit/visit-status.php`, params );
        },

        async visit_delete( context, id ) {
            await $.get( `${ getSiteURL() }/api/delete/visit/visit.php`, { id: id } );
        }, /* delete visit */

    },
    /* -- actions -- */

} );
