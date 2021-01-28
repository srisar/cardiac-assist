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

    mutations: {
        setVisitsList(state, payload) {
            state.visitsList = payload;
        }
    },

    getters: {
        getVisitsList(state) {
            return state.visitsList;
        }
    },

    actions: {

        /*
        * Fetch visits
        * */
        fetchVisits({commit, rootGetters}) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/patient-visits.php`, {
                    id: rootGetters.getPatient.id
                }).done(r => {

                    commit('setVisitsList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });
            });
        },

        addVisit({commit, dispatch}, visit) {

            return new Promise((resolve, reject) => {

                const params = {
                    patient_id: visit.patient_id,
                    visit_date: visit.visit_date,
                    remarks: visit.remarks,
                    height: visit.height,
                    weight: visit.weight,
                    bmi: visit.bmi,
                    bsa: visit.bsa,
                    sbp: visit.sbp,
                    dbp: visit.dbp,
                };

                $.get(`${getSiteURL()}/api/save/visit.php`, params)
                    .done(r => {

                        dispatch('fetchVisits');
                        resolve();
                    })
                    .fail(e => {
                        reject(e);
                    });
            });

        },

    }

};


/*
* ------------------------------------------------------------------------
* Main store
*
* */
export default new Vuex.Store({

    modules: {
        visits: moduleVisits
    },

    state: {

        patient: {
            id: "",
            first_name: "",
            last_name: "",
            dob: moment().format('YYYY-MM-DD'),
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
        fetchPatient({commit, dispatch}, id) {

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
        updatePatient({commit, dispatch}, patient) {

            return new Promise((resolve, reject) => {
                $.post(`${getSiteURL()}/api/update/patient.php`, {
                    id: patient.id,
                    first_name: patient.first_name,
                    last_name: patient.last_name,
                    dob: patient.dob,
                    age: patient.age,
                    address: patient.address,
                    ds_division: patient.ds_division,
                    nic: patient.nic,
                    phone: patient.phone,
                    gender: patient.gender,
                    job: patient.job,
                    job_type: patient.job_type,
                    income: patient.income,
                    status: patient.status,
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



