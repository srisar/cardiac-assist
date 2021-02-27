import EditPatientView from "./EditPatientView";
import store from "./store";
import Vue from 'vue';

new Vue({
    render: h => h(EditPatientView),
    store : store,
}).$mount('#app');
