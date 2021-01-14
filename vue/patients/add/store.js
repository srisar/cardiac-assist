import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);


/*
* ------------------------------------------------------------------------
* Main store
*
* */
export default new Vuex.Store({

    state: {},

    mutations: {},

    getters: {},

    actions: {

        /*
        * Update patient
        * */
        savePatient({commit}, patient) {

            return new Promise((resolve, reject) => {
                $.post(`${getSiteURL()}/api/save/patient.php`, {
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

                    resolve(r);

                }).fail(e => {
                    reject(e);
                });

            });

        },

    }

});



