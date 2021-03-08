import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);


/*
* Module: visits
* */
const moduleVisits = {

    state: {
        visitsList: [],
    },

    /*
    * === MUTATIONS ===
    * */
    mutations: {

        setVisitsList(state, list) {
            state.visitsList = list
        },

    },

    /*
    * === GETTERS ===
    * */
    getters: {

        getVisitsList(state) {
            return state.visitsList
        },

    },

    /*
    * === ACTIONS ===
    * */
    actions: {

        /*
        * Fetch visits
        * */
        fetchVisits({ commit, rootGetters }) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/patient-visits.php`, {
                    id: rootGetters.getPatient.id
                }).done(r => {

                    commit('setVisitsList', r.data)
                    resolve()

                }).fail(e => {
                    reject(e)
                })
            })

        }, /* fetch visits */

        addVisit({ commit, dispatch }, visit) {

            return new Promise((resolve, reject) => {

                const params = {
                    patient_id: visit.patient_id,
                    visit_date: visit.visit_date,
                    remarks   : visit.remarks,
                    height    : visit.height,
                    weight    : visit.weight,
                    bmi       : visit.bmi,
                    bsa       : visit.bsa,
                    sbp       : visit.sbp,
                    dbp       : visit.dbp,
                };

                $.get(`${getSiteURL()}/api/save/visit.php`, params)
                    .done(r => {

                        dispatch('fetchVisits')
                        resolve()
                    })
                    .fail(e => {
                        reject(e)
                    });
            });

        }, /* add visit*/


    }

};

/* Module: appointments */
const moduleAppointments = {
    state: {
        appointmentsList: [],
    },

    getters: {
        getAppointmentsList(state) {
            return state.appointmentsList
        }
    },

    mutations: {
        setAppointmentsList(state, list) {
            state.appointmentsList = list
        }
    },

    actions: {
        fetchAppointments({ rootGetters, commit }) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/patient-appointments.php`, {
                    id: rootGetters.getPatient.id
                }).done(r => {

                    commit('setAppointmentsList', r.data)
                    resolve()

                }).fail(e => {
                    reject(e)
                });

            })
        }, /* fetch appointments */

        addAppointment({ dispatch }, appointment) {
            return new Promise((resolve, reject) => {
                $.post(`${getSiteURL()}/api/save/appointment.php`, appointment)
                    .done(r => {
                        resolve()
                    })
                    .fail(e => {
                        reject(e)
                    })
            })

        }, /* add appointment */

        editAppointment({ dispatch }, appointment) {
            return new Promise((resolve, reject) => {
                $.post(`${getSiteURL()}/api/update/appointment.php`, appointment)
                    .done(r => {
                        dispatch('fetchAppointments')
                        resolve()
                    })
                    .fail(e => {
                        reject(e)
                    })
            })
        }, /* update appointment */

        deleteAppointment: function ({ dispatch }, id) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: id
                }

                $.post(`${getSiteURL()}/api/delete/appointment.php`, params)
                    .done(r => {

                        dispatch('fetchAppointments')
                            .then(() => {
                                resolve()
                            })
                    })
                    .fail(e => {
                        reject(e)
                    })
            })

        }, /* delete appointment */

    },
}


/*
* ====== MAIN STORE ======
* */
export default new Vuex.Store({

    modules: {
        visits      : moduleVisits,
        appointments: moduleAppointments
    },

    state: {

        patient: {
            id         : "",
            first_name : "",
            last_name  : "",
            dob        : moment().format('YYYY-MM-DD'),
            age        : 0,
            address    : "",
            ds_division: "",
            nic        : "",
            phone      : "",
            gender     : "",
            job        : "",
            job_type   : "",
            income     : 0,
            status     : "",
        },

    },

    mutations: {
        setPatient(state, payload) {
            state.patient = payload;
        }
    },

    getters: {
        getPatient: (state) => {
            return state.patient;
        }
    },

    actions: {

        /*
        * Fetch patient
        * */
        fetchPatient({ commit, dispatch }, id) {

            return new Promise((resolve, reject) => {
                $.get(`${getSiteURL()}/api/get/patients.php`, {
                    id: id
                }).done(r => {
                    commit('setPatient', r.data);
                    resolve();
                }).fail(e => {
                    reject(e);
                });
            });
        },

        /*
        * Update patient
        * */
        updatePatient({ commit, dispatch }, patient) {

            return new Promise((resolve, reject) => {
                $.post(`${getSiteURL()}/api/update/patient.php`, {
                    id         : patient.id,
                    first_name : patient.first_name,
                    last_name  : patient.last_name,
                    dob        : patient.dob,
                    age        : patient.age,
                    address    : patient.address,
                    ds_division: patient.ds_division,
                    nic        : patient.nic,
                    phone      : patient.phone,
                    gender     : patient.gender,
                    job        : patient.job,
                    job_type   : patient.job_type,
                    income     : patient.income,
                    status     : patient.status,
                }).done(r => {

                    dispatch('fetchPatient', patient.id);
                    resolve(r);

                }).fail(e => {
                    reject(e);
                });

            });

        },

    }

});



