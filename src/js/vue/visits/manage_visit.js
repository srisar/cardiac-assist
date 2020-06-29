import ManageVisitSymptoms from "./symptoms/ManageVisitSymptoms";
import EditVisit from "./visit/EditVisit";
import ManageDiffDiagnosis from "./diff_diagnosis/ManageDiffDiagnosis";

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

/**
 * Manage visit symptoms
 */
new Vue({
    render: h => h(ManageDiffDiagnosis)
}).$mount("#vue_manage_differential_diagnosis");

