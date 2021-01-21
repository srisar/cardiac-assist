import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const PANEL_EDIT = "EDIT"
const PANEL_ADD = "ADD"


export default new Vuex.Store({

    state: {
        investigationsList: [],
        selectedInvestigation: null,

        panelMode: PANEL_ADD,
        editButtonText: "Edit"
    },

    mutations: {

        updateInvestigationsList(state, payload) {
            state.investigationsList = payload;
        },

        updateSelectedInvestigation(state, payload) {
            state.selectedInvestigation = payload;
        },

        setPanelModeEdit(state) {
            state.panelMode = PANEL_EDIT;
        },

        setPanelModeAdd(state) {
            state.panelMode = PANEL_ADD;
        },

        setEditButtonText(state, textValue) {
            state.editButtonText = textValue;
        }

    },

    getters: {},

    actions: {
        fetchInvestigations({commit}, payload) {

            $.get(`${getSiteURL()}/api/get/investigations.php`)
                .done(r => {
                    commit('updateInvestigationsList', r.data);
                })
                .fail(e => {
                    console.log(e.responseJSON.message);
                });

        },

        saveInvestigation({commit, dispatch}, investigation) {

            return new Promise((resolve, reject) => {

                const params = {
                    investigation_name: investigation.investigation_name,
                    description: investigation.description
                };

                $.post(`${getSiteURL()}/api/save/investigation.php`, params)
                    .done(r => {
                        dispatch('fetchInvestigations');
                        resolve(r);
                    })
                    .fail(e => {
                        reject(e);
                    });

            });

        },

        updateInvestigation({commit, dispatch}, investigation) {

            return new Promise((resolve, reject) => {

                const params = {
                    id: investigation.id,
                    investigation_name: investigation.investigation_name,
                    description: investigation.description
                };


                $.post(`${getSiteURL()}/api/update/investigation.php`, params)
                    .done(r => {

                        dispatch('fetchInvestigations');
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });

        },


        deleteInvestigation({commit, dispatch}, investigation) {

            return new Promise((resolve, reject) => {

                const params = {
                    id: investigation.id,
                }

                $.get(`${getSiteURL()}/api/delete/investigation.php`, params)
                    .done(r => {

                        dispatch('fetchInvestigations');
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });

        },


        setSelectedInvestigation({commit, dispatch}, investigation) {
            commit('updateSelectedInvestigation', investigation);
            commit('setPanelModeEdit');
            commit('setEditButtonText', 'Edit');

        }
    }

});
