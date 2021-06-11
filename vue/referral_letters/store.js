import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const Store = new Vuex.Store({

    state: {

        letters: [],
        selectedLetter: {},

    },
    getters: {
        getLetters(state) {
            return state.letters;
        },

        getSelectedLetter(state) {
            return state.selectedLetter;
        },

    },

    mutations: {

        setLetters(state, data) {
            state.letters = data;
        },

        setSelectedLetter(state, data) {
            state.selectedLetter = data;
        },

    },

    actions: {


        async letters_fetch(context, id) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/referral-letters.php`, {id: id});
                context.commit("setSelectedDrug", response.data);

            } catch (e) {
                throw e;
            }

        }, /* fetch all */

        async letters_fetchAll(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/referral-letters.php`);
                context.commit("setDrugs", response.data);

            } catch (e) {
                throw e;
            }

        }, /* fetch all */


        async letters_save(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/save/referral-letter.php`, params);

            } catch (e) {
                throw e;
            }

        }, /* save */

        async letters_update(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/update/referral-letter.php`, params);

            } catch (e) {
                throw e;
            }

        }


    },


});

export default Store;
