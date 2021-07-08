import Vuex from "vuex";
import Vue from "vue";

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
            state.visitsList = list
        },
    },

    getters: {
        getVisitsList( state ) {
            return state.visitsList
        },
    },

    actions: {

        async visits_fetchAll( context, patientId ) {

            try {
                const response = await $.get( `${ getSiteURL() }/api/get/patient-visits.php`, { id: patientId } );
                context.state.visitsList = response.data;
            } catch ( e ) {
                throw e;
            }


        }, /* fetch visits */

        async visits_add( context, params ) {

            try {
                await $.get( `${ getSiteURL() }/api/save/visit/visit.php`, params );
            } catch ( e ) {
                throw e;
            }

        }, /* add visit*/

    }
    /* -- actions -- */

};

/* Module: appointments */
const moduleAppointments = {
    state: {
        appointmentsList: [],
    },

    getters: {
        getAppointmentsList( state ) {
            return state.appointmentsList
        },
    },

    mutations: {
        setAppointmentsList( state, list ) {
            state.appointmentsList = list
        },
    },

    actions: {

        async appointments_fetchAll( context, patientId ) {

            try {
                const response = await $.get( `${ getSiteURL() }/api/get/patient-appointments.php`, { id: patientId } );
                context.state.appointmentsList = response.data;
            } catch ( e ) {
                throw e;
            }

        }, /* fetch appointments */

        async appointments_add( context, params ) {

            try {
                await $.post( `${ getSiteURL() }/api/save/appointment.php`, params );
            } catch ( e ) {
                throw e;
            }

        }, /* add appointment */

        async appointments_update( context, params ) {

            try {
                $.post( `${ getSiteURL() }/api/update/appointment.php`, params );
            } catch ( e ) {
                throw e;
            }
        }, /* update appointment */

        async appointments_delete( context, id ) {

            try {
                $.post( `${ getSiteURL() }/api/delete/appointment.php`, { id: id } );
            } catch ( e ) {
                throw e;
            }
        }, /* delete appointment */

    },
}


export default new Vuex.Store( {

    modules: {
        visits: moduleVisits,
        appointments: moduleAppointments
    },

    state: {

        patient: {
            id: "",
            first_name: "",
            last_name: "",
            dob: moment().format( "YYYY-MM-DD" ),
            age: 0,
            address: "",
            ds_division: "",
            nic: "",
            phone: "",
            gender: "",
            job: "",
            job_type: "",
            income: 0,
            status: "",
        },

    },

    mutations: {
        setPatient( state, payload ) {
            state.patient = payload;
        }
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

            // return new Promise( ( resolve, reject ) => {
            //     $.post( `${ getSiteURL() }/api/update/patient.php`, {
            //         id: patient.id,
            //         first_name: patient.first_name,
            //         last_name: patient.last_name,
            //         dob: patient.dob,
            //         age: patient.age,
            //         address: patient.address,
            //         ds_division: patient.ds_division,
            //         nic: patient.nic,
            //         phone: patient.phone,
            //         gender: patient.gender,
            //         job: patient.job,
            //         job_type: patient.job_type,
            //         income: patient.income,
            //         status: patient.status,
            //     } ).done( r => {
            //
            //         dispatch( "fetchPatient", patient.id );
            //         resolve( r );
            //
            //     } ).fail( e => {
            //         reject( e );
            //     } );
            //
            // } );

        },

    }

} );



