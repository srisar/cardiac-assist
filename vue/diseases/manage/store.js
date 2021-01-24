import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const PANEL_EDIT = "EDIT"
const PANEL_ADD = "ADD"


export default new Vuex.Store({

    state: {
        diseasesList: [],
        selectedDisease: null,

        panelMode: PANEL_ADD,
        editButtonText: "Edit"
    },

    mutations: {

        updateDiseasesList(state, payload) {
            state.diseasesList = payload;
        },

        updateSelectedDisease(state, payload) {
            state.selectedDisease = payload;
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
        getDiseasesList: state => {
            return state.diseasesList;
        },

        getSelectedDisease: state => {
            return state.selectedDisease;
        },

        getPanelMode: state => {
            return state.panelMode;
        },
        getEditButtonText: state => {
            return state.editButtonText;
        },
    },

    actions: {

        /*
        * Fetch all available diseases
        * */
        fetchDiseases({commit}, payload) {

            $.get(`${getSiteURL()}/api/get/diseases.php`)
                .done(r => {
                    commit('updateDiseasesList', r.data);
                })
                .fail(e => {
                    console.log(e.responseJSON.message);
                });

        },

        /*
        * Save a new disease
        * */
        saveDisease({commit, dispatch}, disease) {

            return new Promise((resolve, reject) => {

                const params = {
                    disease: disease.disease,
                    disease_code: disease.disease_code,
                    description: disease.description,
                };

                $.post(`${getSiteURL()}/api/save/disease.php`, params)
                    .done(r => {
                        dispatch('fetchDiseases');
                        resolve(r);
                    })
                    .fail(e => {
                        reject(e);
                    });

            });

        },

        /*
        * Update disease
        * */
        updateDisease({commit, dispatch}, disease) {

            return new Promise((resolve, reject) => {

                const params = {
                    id: disease.id,
                    disease: disease.disease,
                    disease_code: disease.disease_code,
                    description: disease.description,
                };

                $.post(`${getSiteURL()}/api/update/disease.php`, params)
                    .done(r => {

                        dispatch('fetchDiseases');
                        resolve(r);

                    })
                    .fail(e => {
                        reject(e);
                    });

            });

        },


        /*
        * Delete existing disease
        * */
        deleteDisease({commit, dispatch}, disease) {

            return new Promise((resolve, reject) => {

                const params = {
                    id: disease.id,
                }

                $.post(`${getSiteURL()}/api/delete/disease.php`, params)
                    .done(r => {

                        dispatch('fetchDiseases');
                        resolve();

                    }).fail(e => {
                    reject(e);
                });


            });

        },


        setSelectedDisease({commit, dispatch}, disease) {
            commit('updateSelectedDisease', disease);
            commit('setPanelModeEdit');
            commit('setEditButtonText', 'Edit');

        }
    }

});
