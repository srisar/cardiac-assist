import ManageVisitSymptoms from "./symptoms/ManageVisitSymptoms";
import EditVisit from "./visit/EditVisit";


window.Vue = require("vue");

/**
 * Manage visit
 */
new Vue({
    render: h => h(EditVisit)
}).$mount("#vue_manage_visit");


/**
 * Manage visit symptoms
 */
new Vue({
    render: h => h(ManageVisitSymptoms)
}).$mount("#vue_manage_visit_symptoms");

