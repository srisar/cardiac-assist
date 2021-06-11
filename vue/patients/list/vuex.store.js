import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        patientsList: [],
    },

    getters: {
        getPatientsList(state) {
            return state.patientsList;
        }
    },

    mutations: {},

    actions: {

        async patients_fetchAll(context) {
            try {

                const response = await $.get(`${getSiteURL()}/api/get/patients.php`);
                context.state.patientsList = response.data;

            } catch (e) {
                throw e;
            }
        },

        async patients_search(context, keyword) {
            try {

                const response = await $.get(`${getSiteURL()}/api/search/patients.php?query=${keyword}`);
                context.state.patientsList = response.data;

            } catch (e) {
                throw e;
            }
        },


    },

});
