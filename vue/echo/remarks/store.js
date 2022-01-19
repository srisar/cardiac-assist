import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

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
            return state.echoValues;
        },

        getEchoValueTypes: function (state) {
            return state.echoValueTypes;
        }

    },

    mutations: {

        setEchoValues: function (state, values) {
            state.echoValues = values;
        }

    },

    actions: {

        FETCH_ALL: async function ({commit}) {

            const response = await $.get(`${getSiteURL()}/api/get/echo/echo-remarks.php`);
            commit('setEchoValues', response);

        },/* fetch all */

        UPDATE: async function ({commit, dispatch}, item) {

            await $.post(`${getSiteURL()}/api/update/echo/echo-remarks.php`, item);
            await dispatch('FETCH_ALL');

        },/* update */


        SAVE: async function ({commit, dispatch}, item) {

            await $.post(`${getSiteURL()}/api/save/echo/echo-remarks.php`, item);
            await dispatch('FETCH_ALL');

        },/* save */

        DELETE: async function ({commit, dispatch}, id) {

            await $.post(`${getSiteURL()}/api/delete/echo/echo-remarks.php`, {id: id});
            await dispatch('FETCH_ALL');

        },/* save */

    },
});
