import Vue from 'vue';
import Vuex from 'vuex';

Vue.use( Vuex );

export default new Vuex.Store( {

    state: {
        patientsStats: {},

        statuses: {
            pending: 'PENDING',
            completed: 'COMPLETED',
            missed: 'MISSED',
            cancelled: 'CANCELLED',
        },
    },

    getters: {
        getPatientsStats( state ) {
            return state.patientsStats;
        },

        getAppointmentStatuses( state ) {
            return state.statuses;
        },
    },

    actions: {

        async patients_getStats( context ) {
            context.state.patientsStats = await $.get( `${ getSiteURL() }/api/stats/patients.php` );
        }, /* get patients stats */


        async appointments_fetchByDate( context, params = { date: '', status: '' } ) {
            const response = await $.get( `${ getSiteURL() }/api/get/appointments/by-date.php`, params );
            return response.data;
        },

        async appointments_fetchBetweenDates( context, params ) {

            /*
            * params: start_date, end_date
            * */
            const response = await $.get( `${ getSiteURL() }/api/get/appointments/between-dates.php`, params );
            return response.data;
        },

        async appointments_fetchByDateExceptPending( context, params = { date: '', status: '' } ) {
            const response = await $.get( `${ getSiteURL() }/api/get/appointments/by-date.php`, params );
            return response.data;
        },

        async appointments_setStatus( context, params ) {
            /*
            * params: id, status
            * */
            await $.get( `${ getSiteURL() }/api/update/appointment-status.php`, params );
        },

        async appointments_update( context, params ) {
            $.post( `${ getSiteURL() }/api/update/appointment.php`, params );
        },

        /*
         * -------------------------------------------------------------------------------------------------
         * STATS
         * -------------------------------------------------------------------------------------------------
         */

        async stats_fetchAllDiagnoses( context ) {
            const response = await $.post( `${ getSiteURL() }/api/stats/all-diagnoses.php` );
            return response;
        },

    },

} );
