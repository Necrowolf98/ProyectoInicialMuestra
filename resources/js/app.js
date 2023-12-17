require("./bootstrap");
require("./plugins/elementui");

import Vue from "vue";
import vuetify from "./plugins/vuetify";

import {  App as InertiaApp, plugin as InertiaPlugin } from "@inertiajs/inertia-vue";
import { Link } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";

window.Fire = new Vue();

Vue.use(InertiaPlugin);
Vue.component("Link", Link);
Vue.mixin({ methods: { route: window.route } });

const app = document.getElementById("app");

new Vue({
    vuetify,
    render: h =>
    h(InertiaApp, {
        props: {
            title: title => `${title} - My App`,
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./pages/${name}`).default
        }
    })
}).$mount(app);

InertiaProgress.init({ color: "#29d"});
