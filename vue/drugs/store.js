import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const Store = new Vuex.Store({

    state: {

        drugs: [],
        selectedDrug: {},

        panelMode: "ADD",

    },
    getters: {
        getDrugs(state) {return state.drugs; },
        getSelectedDrug(state) {return state.selectedDrug; },

        getPanelMode(state) { return state.panelMode; },
    },
    mutations: {

        setDrugs(state, data) { state.drugs = data; },
        setSelectedDrug(state, data) { state.selectedDrug = data; },

        setPanelModeAdd(state) { state.panelMode = "ADD"; },
        setPanelModeEdit(state) { state.panelMode = "EDIT"; },

    },
    actions: {

        async drugs_fetchAll(context) {

            try {

                const response = await $.get(`${getSiteURL()}/api/get/drugs.php`);
                context.commit("setDrugs", response.data);

            } catch (e) {
                throw e;
            }

        }, /* fetch all */


        async drugs_save(context, params) {

            try {

                await $.post(`${getSiteURL()}/api/save/drug.php`, params);

            } catch (e) {
                throw e;
            }

        }, /* save */

        async drugs_update(context, params){

            try{

                await $.post(`${getSiteURL()}/api/update/drug.php`, params);

            }catch (e) {
                throw e;
            }

        }


    },


});

export default Store;
