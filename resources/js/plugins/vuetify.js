import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";

/* import colors from "vuetify/lib/util/colors"; */


/* const options = {
    theme: {
        light: true,
        themes: {
            light: {
                primary: colors.blue.darken2,
                accent: colors.grey.darken3,
                secondary: colors.amber.darken3,
                info: colors.teal.lighten1,
                warning: colors.amber.base,
                error: colors.deepOrange.accent4,
                success: colors.green.accent3
            }
        }
    },
    
    icons: {
        iconfont: "mdi"
    }
}; */


Vue.use(Vuetify);

export default new Vuetify();
