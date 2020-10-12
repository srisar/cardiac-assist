import ManageDiseases from "./ManageDiseases";

window.Vue = require("vue");

new Vue({
    render: h => h(ManageDiseases)
}).$mount("#app_manage_diseases");