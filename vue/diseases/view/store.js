import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({

    state: {
        selectedDisease: {
            id: "",
            disease: "",
            disease_code: "",
            description: "",
        },

        editButtonText: "Edit"
    },

    mutations: {


        updateSelectedDisease(state, payload) {
            state.selectedDisease = payload;
        },


        setEditButtonText(state, textValue) {
            state.editButtonText = textValue;
        }

    },

    getters: {

        selectedDisease: state => {
            return state.selectedDisease;
        },


        editButtonText: state => {
            return state.editButtonText;
        },
    },

    actions: {
        fetchDisease({commit}, id) {

            $.get(`${getSiteURL()}/api/get/diseases.php`, {
                id: id
            })
                .done(r => {
                    commit('updateSelectedDisease', r.data);
                })
                .fail(e => {
                    console.log(e);
                });

        },


        updateDisease({commit, dispatch}, disease) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/update/disease.php`, {
                    id: disease.id,
                    disease: disease.disease,
                    disease_code: disease.disease_code,
                    description: disease.description,
                }).done(r => {

                    resolve('Success');

                }).fail(e => {
                    reject(e);
                });

            });

        },

        setSelectedDisease({commit, dispatch}, symptom) {
            commit('updateSelectedSymptom', symptom);
            commit('setPanelModeEdit');
            commit('setEditButtonText', 'Edit');

        }
    }

});
