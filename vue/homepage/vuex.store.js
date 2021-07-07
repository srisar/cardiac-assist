import Vue from "vue";
import Vuex from "vuex";

Vue.use( Vuex );

export default new Vuex.Store( {

    state: {
        patientsStats: {},

        statuses: {
            pending: "PENDING",
            completed: "COMPLETED",
            missed: "MISSED",
            cancelled: "CANCELLED",
        },
    },

    getters: {
        getPatientsStats( state ) {
            return state.patientsStats;
        },

        getAppointmentStatuses( state ) {
            return state.statuses;
        }
    },

    actions: {

        async patients_getStats( context ) {
            try {
                context.state.patientsStats = await $.get( `${ getSiteURL() }/api/stats/patients.php` );
            } catch ( e ) {
                throw e;
            }
        }, /* get patients stats */


        async appointments_fetchByDate( context, params = { date: "", status: "" } ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/appointments/by-date.php`, params );
                return response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async appointments_fetchBetweenDates( context, params ) {

            /*
            * params: start_date, end_date
            * */

            try {
                const response = await $.get( `${ getSiteURL() }/api/get/appointments/between-dates.php`, params );
                return response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async appointments_fetchByDateExceptPending( context, params = { date: "", status: "" } ) {
            try {
                const response = await $.get( `${ getSiteURL() }/api/get/appointments/by-date.php`, params );
                return response.data;
            } catch ( e ) {
                throw e;
            }
        },

        async appointments_setStatus( context, params ) {
            /*
            * params: id, status
            * */
            try {
                await $.get( `${ getSiteURL() }/api/update/appointment-status.php`, params );
            } catch ( e ) {
                throw e;
            }
        }

    },

} )
