import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({

    state: {
        investigationsList: [],
        selectedInvestigation: null,
    },

    getters: {

        getInvestigationsList(state) {
            return state.investigationsList;
        },

        getSelectedInvestigation(state) {
            return state.selectedInvestigation;
        }

    },

    mutations: {

        setInvestigationsList(state, data) {
            state.investigationsList = data;
        },

        setSelectedInvestigation(state, data) {
            state.selectedInvestigation = data;
        },

    },

    actions: {


        /* fetch all */
        async investigations_fetchAll(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/investigations.php`);
                context.commit("setInvestigationsList", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* fetch */
        async investigations_fetch(context, id) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/investigations.php`, {id: id});
                context.commit("setSelectedInvestigation", response.data);

            } catch (e) {
                throw e;
            }

        },

        /* add */
        async investigations_add(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/save/investigation.php`, params);
            } catch (e) {
                throw e;
            }
        },


        /* update */
        async investigations_update(context, params) {

            try {
                await $.post(`${getSiteURL()}/api/update/investigation.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* update */
        async investigations_delete(context, id) {

            try {
                await $.post(`${getSiteURL()}/api/delete/investigation.php`, {id: id});
            } catch (e) {
                throw e;
            }
        },

    }

});
