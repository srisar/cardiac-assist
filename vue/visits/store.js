import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export default new Vuex.Store({

    state: {

    },

    mutations: {
        updateValue(state, payload) {
            state.value = payload;
        }
    },

    getters: {
        value: value => {
            return state.value;
        }
    },

    actions: {
        updateValue({commit}, payload) {
            commit(updateValue, payload);
        }
    }

});
