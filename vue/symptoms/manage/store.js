import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const PANEL_EDIT = "EDIT"
const PANEL_ADD = "ADD"


export default new Vuex.Store({

    state: {
        symptomsList: [],
        selectedSymptom: null,

        panelMode: PANEL_ADD,
        editButtonText: "Edit"
    },

    mutations: {

        updateSymptomsList(state, payload) {
            state.symptomsList = payload;
        },

        updateSelectedSymptom(state, payload) {
            state.selectedSymptom = payload;
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

    getters: {
        getSymptomsList: state => {
            return state.symptomsList;
        },

        getSelectedSymptom: state => {
            return state.selectedSymptom;
        },

        getPanelMode: state => {
            return state.panelMode;
        },
        getEditButtonText: state => {
            return state.editButtonText;
        },
    },

    actions: {
        fetchSymptoms({commit}, payload) {

            $.get(`${getSiteURL()}/api/get/symptoms.php`)
                .done(r => {
                    commit('updateSymptomsList', r.data);
                })
                .fail(e => {
                    console.log(e.responseJSON.message);
                });

        },

        saveSymptom({commit, dispatch}, symptom) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/save/symptom.php`, {
                    symptom_name: symptom.symptom_name,
                    description: symptom.description,
                }).done(r => {
                    dispatch('fetchSymptoms');
                    resolve(r);
                }).fail(e => {
                    reject(e);
                });

            });

        },

        updateSymptom({commit, dispatch}, symptom) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/update/symptom.php`, {
                    id: symptom.id,
                    symptom_name: symptom.symptom_name,
                    description: symptom.description,
                }).done(r => {

                    resolve(`${symptom.symptom_name} updated`);

                }).fail(e => {
                    reject(e);
                });

            });

        },

        setSelectedSymptom({commit, dispatch}, symptom) {
            commit('updateSelectedSymptom', symptom);
            commit('setPanelModeEdit');
            commit('setEditButtonText', 'Edit');

        }
    }

});
