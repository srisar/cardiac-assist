import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);


export default new Vuex.Store({

    state: {
        symptomsList: [],
        selectedSymptom: null,

    },


    getters: {
        getSymptomsList(state) {
            return state.symptomsList;
        },

        getSelectedSymptom(state) {
            return state.selectedSymptom;
        },


    },

    mutations: {

        setSymptomsList(state, payload) {
            state.symptomsList = payload;
        },

        setSelectedSymptom(state, payload) {
            state.selectedSymptom = payload;
        },

    },


    actions: {

        /* fetch all */
        async symptoms_fetchAll(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/symptoms.php`);
                context.commit("setSymptomsList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* fetch */
        async symptoms_fetch(context, id) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/symptoms.php`, {id: id});
                context.commit("setSelectedSymptom", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* add */
        async symptoms_add(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/save/symptom.php`, params);
            } catch (e) {
                throw e;
            }
        },


        /* update */
        async symptoms_update(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/update/symptom.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* delete */
        async symptoms_delete(context, id) {

            try {
                await $.post(`${getSiteURL()}/api/delete/symptom.php`, {id: id});
            } catch (e) {
                throw e;
            }
        },


    }

});
