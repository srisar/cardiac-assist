import Vue from "vue";
import {store} from "./store";
import VueRouter from "vue-router";
import ManageProblems from "./ManageProblems";
import SaveProblem from "./components/SaveProblem";
import EditProblem from "./components/EditProblem";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: SaveProblem
    },
    {
        path: "/add",
        component: SaveProblem
    },
    {
        path: "/edit/:id",
        component: EditProblem
    }
];

const router = new VueRouter({routes});

new Vue({
    render: h => h(ManageProblems),
    store: store,
    router: router
}).$mount("#app");

