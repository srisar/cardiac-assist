import Vue from 'vue';
import Vuex from 'vuex';

Vue.use( Vuex );


/*
* Module: visits
* */
const moduleVisits = {

    state: {
        visitsList: [],
    },

    mutations: {
        setVisitsList( state, list ) {
            state.visitsList = list;
        },
    },

    getters: {
        getVisitsList( state ) {
            return state.visitsList;
        },
    },

    actions: {

        async visits_fetchAll( context, patientId ) {
            const response = await $.get( `${ getSiteURL() }/api/get/patient-visits.php`, { id: patientId } );
            context.state.visitsList = response.data;
        }, /* fetch visits */

        async visits_add( context, params ) {
            await $.get( `${ getSiteURL() }/api/save/visit/visit.php`, params );
        }, /* add visit*/

    },
    /* -- actions -- */

};

/* Module: appointments */
const moduleAppointments = {
    state: {
        appointmentsList: [],
    },

    getters: {
        getAppointmentsList( state ) {
            return state.appointmentsList;
        },
    },

    mutations: {
        setAppointmentsList( state, list ) {
            state.appointmentsList = list;
        },
    },

    actions: {

        async appointments_fetchAll( context, patientId ) {

            const response = await $.get( `${ getSiteURL() }/api/get/patient-appointments.php`, { id: patientId } );
            context.state.appointmentsList = response['data'];

        }, /* fetch appointments */

        async appointments_add( context, params ) {
            await $.post( `${ getSiteURL() }/api/save/appointment.php`, params );

        }, /* add appointment */

        async appointments_update( context, params ) {
            $.post( `${ getSiteURL() }/api/update/appointment.php`, params );
        }, /* update appointment */

        async appointments_delete( context, id ) {
            $.post( `${ getSiteURL() }/api/delete/appointment.php`, { id: id } );
        }, /* delete appointment */

        async appointments_setStatus( context, params ) {
            /*
            * params: id, status
            * */
            await $.get( `${ getSiteURL() }/api/update/appointment-status.php`, params );
        },

    },
};


export default new Vuex.Store( {

    modules: {
        visits: moduleVisits,
        appointments: moduleAppointments,
    },

    state: {

        patient: {
            id: '',
            first_name: '',
            last_name: '',
            dob: moment().format( 'YYYY-MM-DD' ),
            age: 0,
            address: '',
            ds_division: '',
            nic: '',
            phone: '',
            gender: '',
            job: '',
            job_type: '',
            income: 0,
            status: '',
        },

    },

    mutations: {
        setPatient( state, payload ) {
            state.patient = payload;
        },
    },

    getters: {
        getPatient( state ) {
            return state.patient;
        },
    },

    actions: {

        async patient_fetch( context, id ) {

            try {
                const response = await $.get( `${ getSiteURL() }/api/get/patients.php`, { id: id } );
                context.state.patient = response.data;
            } catch ( e ) {
                throw e;
            }

        }, /* fetch */


        async patient_update( context, params ) {

            try {
                await $.post( `${ getSiteURL() }/api/update/patient.php`, params );
            } catch ( e ) {
                throw e;
            }
        }, /* update */

        async patient_delete( context, id ) {
            await $.post( `${ getSiteURL() }/api/delete/patient.php`, { id: id } );
        },

    },

} );



