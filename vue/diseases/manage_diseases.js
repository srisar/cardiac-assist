import ManageDiseases from "./ManageDiseases";

import {createApp} from "vue";


const app = createApp(ManageDiseases);
app.mount("#app_manage_disease");

// new Vue({
//     render: h => h(ManageDiseases)
// }).$mount("#app_manage_diseases");