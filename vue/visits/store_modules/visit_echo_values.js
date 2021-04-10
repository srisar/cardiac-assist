export default {

    state: {

        echoRemarksTypes: {
            'LEFT_VENTRICLE': 'Left Ventricle',
            'LEFT_ATRIUM': 'Left Atrium',
            'MITRAL_VALVE': 'Mitral Valve',
            'AORTIC_VALVE': 'Aortic Valve',
            'AORTA': 'Aorta',
            'RIGHT_VENTRICLE': 'Right Ventricle / Pulmonary Artery',
            'RIGHT_ATRIUM': 'Right Atrium',
            'PULMONIC_VALVE': 'Pulmonic Valve',
            'TRICUSPID': 'Tricuspid',
            'PERICARDIUM': 'Pericardium',
            'CONCLUSION': 'Conclusion',
        },

        echoRemarks: [],

        visitEchoRemarks: [],

    },

    getters: {

        getEchoRemarks: function (state) { return state.echoRemarks },
        getVisitEchoRemarks: function (state) { return state.visitEchoRemarks },
        getEchoRemarksTypes: function (state) { return state.echoRemarksTypes },

    },

    mutations: {
        setEchoRemarks: function (state, values) { state.echoRemarks = values },
        setVisitEchoRemarks: function (state, values) { state.visitEchoRemarks = values },

    },

    actions: {

        FETCH_ALL_ECHO_REMARKS: function ({commit}) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/echo/echo-remarks.php`)
                    .done(response => {

                        commit('setEchoRemarks', response)

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* fetch all */

        FETCH_VISIT_ECHO_REMARKS: function ({commit}, visit_id) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/visit/visit-echo-remarks.php`, {visit_id: visit_id})
                    .done(response => {

                        commit('setVisitEchoRemarks', response)
                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* fetch all */


        ADD_VISIT_ECHO_REMARK: function ({commit, dispatch}, item) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/save/visit/visit-echo-remarks.php`, item)
                    .done(response => {

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        }, /* add visit echo remark */

        DELETE_VISIT_ECHO_REMARK: function ({commit, dispatch}, id) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/delete/visit/visit-echo-remarks.php`, {id: id})
                    .done(response => {

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        }, /* delete */


        SAVE_NEW_ECHO_REMARK: function ({commit, dispatch}, item) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/save/echo/echo-remarks.php`, item)
                    .done(response => {

                        dispatch('FETCH_ALL_ECHO_REMARKS')
                            .catch(() => {
                                reject()
                            })

                        resolve()
                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* save new echo remark */

    },

}
