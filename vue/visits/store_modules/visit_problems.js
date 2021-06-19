/*
* Visit Diagnosis
* */

export const visitProblems = {
    state: {
        visitProblemsList: [],
        problems: [],
    },

    getters: {

        getVisitProblemsList(state) {
            return state.visitProblemsList;
        },

        getProblems(state) {
            return state.problems;
        }

    },

    actions: {

        async visitProblems_fetchAllProblems(context) {
            try {
                const response = await $.get(`${getSiteURL()}/api/get/problems.php`);
                context.state.problems = response.data;
            } catch (e) {
                throw e;
            }
        },

        /* fetch all */
        async visitProblems_fetchAll(context, visitId) {

            try {
                const response = await $.get(`${getSiteURL()}/api/get/visit/visit-problems.php`, {visit_id: visitId});
                context.state.visitProblemsList = response.data;

            } catch (e) {
                throw e;
            }
        },


        /* add */
        async visitProblems_add(context, params) {
            try {
                await $.get(`${getSiteURL()}/api/save/visit/visit-problem.php`, params);
            } catch (e) {
                throw e;
            }
        },

        /* delete */
        async visitProblems_delete(context, id) {

            try {
                await $.get(`${getSiteURL()}/api/delete/visit/visit-problem.php`, {id: id});
            } catch (e) {
                throw e;
            }
        },

        /* save new problem */
        async visitProblems_saveProblem(context, params) {
            try {
                await $.get(`${getSiteURL()}/api/save/problem.php`, params);
            } catch (e) {
                throw e;
            }
        },

    },
    /* *** ACTIONS *** */
};
