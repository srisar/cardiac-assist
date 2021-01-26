import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({

    state: {
        selectedInvestigation: {
            id: "",
            disease: "",
            disease_code: "",
            description: "",
        },

        editButtonText: "Edit"
    },

    mutations: {


        updateSelectedInvestigation(state, payload) {
            state.selectedInvestigation = payload;
        },


        setEditButtonText(state, textValue) {
            state.editButtonText = textValue;
        }

    },

    getters: {

        getSelectedInvestigation: state => {
            return state.selectedInvestigation;
        },


        editButtonText: state => {
            return state.editButtonText;
        },
    },

    actions: {
        fetchInvestigation({commit}, id) {

            $.get(`${getSiteURL()}/api/get/investigations.php`, {
                id: id
            }).done(r => {
                commit('updateSelectedInvestigation', r.data);
            }).fail(e => {
                console.log(e);
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

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },


    }

});
