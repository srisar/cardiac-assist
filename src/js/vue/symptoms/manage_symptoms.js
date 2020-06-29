import ManageSymptoms from "./ManageSymptoms";

window.Vue = require("vue");

new Vue({
    render: h => h(ManageSymptoms)
}).$mount("#app_manage_symptoms");