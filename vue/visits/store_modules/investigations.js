/*
* Investigations
* */

export default {
    state: {

        investigationsList: [],

    },

    mutations: {

        updateInvestigationsList(state, payload) {
            state.investigationsList = payload;
        },

    },

    getters: {

        investigationsList: state => {
            return state.investigationsList;
        },


    },

    actions: {

        /*
        * Fetch all investigations for the visit
        * */
        fetchInvestigations: function ({commit}, visitId) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/investigations.php`, {
                    visit_id: visitId
                }).done(r => {

                    commit('updateInvestigationsList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        /*
        * Add diff. diagnosis
        * */
        addInvestigation: function ({commit, dispatch, rootGetters}, investigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    visit_id: rootGetters.getVisit.id,
                    investigation_name: investigation.investigation_name,
                    description: investigation.description
                };

                console.log(params);

                $.get(`${getSiteURL()}/api/save/investigation.php`, params)
                    .done(r => {

                        dispatch('fetchInvestigations', params.visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        /*
        * Delete diff. diagnosis
        * */
        deleteInvestigation: function ({commit, dispatch, rootGetters}, investigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: investigation.id,
                }

                $.get(`${getSiteURL()}/api/delete/investigation.php`, params)
                    .done(r => {

                        const visit_id = rootGetters.getVisit.id;
                        dispatch('fetchInvestigations', visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        updateInvestigation: function ({commit, dispatch, rootGetters}, investigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: investigation.id,
                    investigation_name: investigation.investigation_name,
                    description: investigation.description
                };

                $.get(`${getSiteURL()}/api/update/investigation.php`, params)
                    .done(r => {

                        const visit_id = rootGetters.getVisit.id;
                        dispatch('fetchInvestigations', visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        }

    }
};
