import ManageUserApp from "./ManageUserApp";


window.Vue = require("vue");

new Vue({
    render: h => h(ManageUserApp)
}).$mount("#app");