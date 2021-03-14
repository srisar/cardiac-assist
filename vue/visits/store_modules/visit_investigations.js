/*
* Investigations
* */

export default {
    state: {

        visitInvestigationsList: [],
        investigationsList: [],

    },

    mutations: {

        updateInvestigationsList: function (state, data) {
            state.investigationsList = data;
        },

        updateVisitInvestigationsList: function (state, data) {
            state.visitInvestigationsList = data;
        },

    },

    getters: {
        getInvestigationsList: function (state) {
            return state.investigationsList;
        },

        getVisitInvestigationsList: function (state) {
            return state.visitInvestigationsList;
        }
    },

    actions: {

        /*
        * Fetch all investigations available
        * */
        fetchInvestigations: function ({state, commit}) {

            return new Promise(((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/investigations.php`)
                    .done(r => {

                        commit('updateInvestigationsList', r.data);
                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });
            }));
        },

        /*
        * Fetch all investigations for the visit
        * */
        fetchVisitInvestigations: function ({commit, state}, visitId) {
            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visit-investigations.php`, {
                    visit_id: visitId
                }).done(r => {

                    commit('updateVisitInvestigationsList', r.data);
                    resolve();

                }).fail(e => {
                    reject(e);
                });

            });
        },

        /*
        * Add diff. diagnosis
        * */
        addVisitInvestigation: function ({commit, dispatch, rootState}, investigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    visit_id: rootState.visit.id,
                    investigation_id: investigation.investigation_id,
                    remarks: investigation.remarks
                };

                console.log(params);

                $.get(`${getSiteURL()}/api/save/visit/visit-investigation.php`, params)
                    .done(r => {

                        dispatch('fetchVisitInvestigations', params.visit_id);
                        resolve(r);

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        /*
        * Delete diff. diagnosis
        * */
        deleteVisitInvestigation: function ({commit, dispatch, rootState}, investigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: investigation.id,
                }

                $.get(`${getSiteURL()}/api/delete/visit/visit-investigation.php`, params)
                    .done(r => {

                        const visit_id = rootState.visit.id;
                        dispatch('fetchVisitInvestigations', visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        },

        updateVisitInvestigation: function ({commit, dispatch, rootState}, visitInvestigation) {
            return new Promise((resolve, reject) => {

                const params = {
                    id: visitInvestigation.id,
                    remarks: visitInvestigation.remarks
                };

                $.get(`${getSiteURL()}/api/update/visit/visit-investigation.php`, params)
                    .done(r => {

                        const visit_id = rootState.visit.id;
                        dispatch('fetchVisitInvestigations', visit_id);

                        resolve();

                    })
                    .fail(e => {
                        reject(e);
                    });

            });
        }

    }
};
