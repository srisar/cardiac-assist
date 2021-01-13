import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({

    state: {
        selectedSymptom: {
            id: "",
            symptom_name: "",
            description: "",
        },
        editButtonText: "Edit"
    },

    mutations: {


        updateSelectedSymptom(state, payload) {
            state.selectedSymptom = payload;
        },


        setEditButtonText(state, textValue) {
            state.editButtonText = textValue;
        }

    },

    getters: {

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
        fetchSymptom({commit}, id) {

            $.get(`${getSiteURL()}/api/get/symptoms.php`, {
                id: id
            })
                .done(r => {
                    commit('updateSelectedSymptom', r.data);
                })
                .fail(e => {
                    console.log(e);
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
