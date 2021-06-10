import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({

    /* *** STATE *** */
    state: {

        patientsStats: {}

    },
    /* *** STATE *** */

    getters: {
        getPatientsStats(state) {
            return state.patientsStats;
        },
    },

    /* *** MUTATIONS *** */
    mutations: {},
    /* *** MUTATIONS *** */

    /* *** ACTIONS *** */
    actions: {

        async patients_getStats(context) {
            try {

                const response = await $.get(`${getSiteURL()}/api/stats/patients.php`);
                console.log(response);
                context.state.patientsStats = response;

            } catch (e) {
                throw e;
            }
        }

    },
    /* *** ACTIONS *** */

})
