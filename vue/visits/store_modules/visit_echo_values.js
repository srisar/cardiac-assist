export default {

    state: {

        echoValueTypes: {
            'AORTA': 'Aorta',
            'AORTIC_VALVE': 'Aortic Valve',
            'DOPPLER': 'Doppler',
            'LEFT_ATRIUM': 'Left Atrium',
            'MITRAL_VALVE': 'Mitral Valve',
            'PERICARDIUM': 'Pericardium',
            'PULMONIC_VALVE': 'Pulmonic Valve',
            'RIGHT_ATRIUM': 'Right Atrium',
            'RIGHT_VENTRICLE': 'Right Ventricle',
            'TRICUSPID': 'Tricuspid',
        },

        echoValues: [],

        visitEchoValues: [],

    },

    getters: {

        getEchoValues: function (state) {
            return state.echoValues
        },

        getVisitEchoValues: function (state) {
            return state.visitEchoValues
        },

        getEchoValueTypes: function (state) {
            return state.echoValueTypes
        },


    },

    mutations: {
        setEchoValues: function (state, values) {
            state.echoValues = values
        },

        setVisitEchoValues: function (state, values) {
            state.visitEchoValues = values
        },

    },

    actions: {

        FETCH_ALL_ECHO_VALUES: function ({commit}) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/echo/echo-values.php`)
                    .done(response => {

                        commit('setEchoValues', response)

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* fetch all */

        FETCH_VISIT_ECHO_VALUES: function ({commit}, visit_id) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visit-echo-values.php`, {visit_id: visit_id})
                    .done(response => {

                        commit('setVisitEchoValues', response)
                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* fetch all */


        ADD_VISIT_ECHO_VALUE: function ({commit, dispatch}, item) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/save/visit/visit-echo-value.php`, item)
                    .done(response => {

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        }, /* add visit echo value */

        DELETE_VISIT_ECHO_VALUE: function ({commit, dispatch}, id) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/delete/visit/visit-echo-value.php`, {id: id})
                    .done(response => {

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        }

    },

}
