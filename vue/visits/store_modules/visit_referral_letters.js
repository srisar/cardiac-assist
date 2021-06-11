/*
* Investigations
* */

export const visitReferralLetters = {
    state: {

        letterModels: [],

    },

    getters: {
        getLetterModels(state) {
            return state.letterModels;
        }
    },

    mutations: {},

    actions: {

        async visitLetters_fetchAllModels(context) {
            try {

                const response = await $.get(`${getSiteURL()}/api/get/referral-letters.php`);
                context.state.letterModels = response.data;

            } catch (e) {
                throw e;
            }
        },

    }
};
