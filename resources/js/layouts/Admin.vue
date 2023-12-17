<template>
    <v-app style="overflow: auto !important;">
        <Navbar :auth="user"></Navbar>

        <Sidebar :auth="user"></Sidebar>

        <div class="content-wrapper py-5">
            <section class="content">
                <v-main>
                    <transition name="slide-fade" mode="out-in">
                        <div v-if="animate">
                            <slot />
                        </div>
                    </transition>
                </v-main>
            </section>
        </div>

        <Footer></Footer>

        <aside class="control-sidebar control-sidebar-dark">

        </aside>
        
    </v-app>
</template>

<script>
    import Navbar from './plantilla/Navbar.vue'
    import Sidebar from './plantilla/Sidebar.vue'
    import Footer from './plantilla/Footer.vue'

    export default {
        components: {Navbar, Sidebar, Footer},
        
        data(){
            return{
                animate: false
            };
        },

        mounted(){
            this.animate = true;
        },

        computed: {
            appName() {
                return this.$page.props.appName;
            },

            user() {
                return this.$page.props.auth;
            },
        },

        watch: {
            $page: {
                handler() {
                    const message = this.$page.props.flash.message;
                    if (message != null) {
                        switch (message.type) {
                            case "success":
                                this.$notify({
                                    title: message.title,
                                    message: message.text,
                                    type: message.type,
                                    duration: 1500
                                });
                            break;
                            case "error":
                                this.$notify({
                                    message: message.text,
                                    type: 'error',
                                    duration: 1500
                                });
                            break;
                        }
                    }
                },
            },
        },
    }
</script>

<style>
.slide-fade-enter{
    transform: translateX(20px);
    opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active{
    transition: all 0.2s ease;
}

.slide-fade-leave-to{
    transform: translateX(-20px);
    opacity: 0;
}
</style>