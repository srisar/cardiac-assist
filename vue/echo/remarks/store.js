import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export default new Vuex.Store({

    state: {

        echoValueTypes: {
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

        echoValues: [],

    },

    getters: {

        getEchoValues: function (state) {
            return state.echoValues
        },

        getEchoValueTypes: function (state) {
            return state.echoValueTypes
        }

    },

    mutations: {

        setEchoValues: function (state, values) {
            state.echoValues = values
        }

    },

    actions: {

        FETCH_ALL: function ({commit}) {

            return new Promise((resolve, reject) => {

                $.get(`${getSiteURL()}/api/get/echo/echo-remarks.php`)
                    .done(response => {

                        commit('setEchoValues', response)

                        resolve()

                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* fetch all */

        UPDATE: function ({commit, dispatch}, item) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/update/echo/echo-remarks.php`, item)
                    .done(response => {

                        dispatch('FETCH_ALL')
                            .catch(() => {
                                reject()
                            })

                        resolve()
                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* update */


        SAVE: function ({commit, dispatch}, item) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/save/echo/echo-remarks.php`, item)
                    .done(response => {

                        dispatch('FETCH_ALL')
                            .catch(() => {
                                reject()
                            })

                        resolve()
                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* save */

        DELETE: function ({commit, dispatch}, id) {

            return new Promise((resolve, reject) => {

                $.post(`${getSiteURL()}/api/delete/echo/echo-remarks.php`, {id: id})
                    .done(response => {

                        dispatch('FETCH_ALL')
                            .catch(() => {
                                reject()
                            })

                        resolve()
                    })
                    .fail(error => {
                        reject(error)
                    })

            })

        },/* save */

    },
})
