export const visitPrescriptions = {

    state: {

        visitPrescriptions: [],
        selectedPrescription: {}

    },

    getters: {

        getVisitPrescriptions(state) { return state.visitPrescriptions; },

    },

    mutations: {

        setVisitPrescriptions(state, data) {
            state.visitPrescriptions = data;
        },

    },

    actions: {

        async prescriptions_fetchAll(context, visit_id) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-prescriptions.php`, {visit_id: visit_id});
                context.commit("setVisitPrescriptions", response.data);

            } catch (e) {
                throw e;
            }

        },

    },

};
