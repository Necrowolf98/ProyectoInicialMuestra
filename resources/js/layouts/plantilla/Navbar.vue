<template>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav pl-0">

                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Inicio</a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="dropdown li_logout">
                    <a href="#" class="a_logout d-flex pt-1" data-toggle="dropdown">
                        <v-avatar color="rgb(240, 233, 233)" size="33">
                            <a class="rgb(139, 93, 93)" style="text-decoration: none; color: #252457;" v-text="auth.user.name.charAt(0)+auth.user.lastname.charAt(0)"></a>
                        </v-avatar>
                    </a>

                    <div class="dropdown-menu menu_logout dropdown-menu-sm dropdown-menu-right">
                        <div class="text-center py-1">
                            <v-avatar color="rgb(240, 233, 233)" size="37">
                                <span class="rgb(139, 93, 93)" v-text="auth.user.name.charAt(0)+auth.user.lastname.charAt(0)"></span>
                            </v-avatar>
                        </div>
                        <p class="text-muted text-center my-0 p_logout"><strong>{{ auth.user.name.split(' ', 1)+ ' ' +auth.user.lastname }}</strong></p>
                        <p class="text-muted text-center my-0 py-1 p_logout">
                            <strong>Roles: </strong>
                            <span v-for="(item, index) in auth.roles" :key="index">{{ item+', ' }}</span>
                        </p>
                        <p class="text-center text-muted mx-3 mb-0 p_logout">{{ auth.user.email }}</p>

                        <div class="text-center mt-2">
                            <a class="text-muted">
                                <button class="btn text-muted boton_cerrar_sesion" @click="logout">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Cerrar sesión
                                </button>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>

        </nav>
</template>

<script>
    export default {
        props: ["auth"],
        
        methods: {
            logout() {
                this.$inertia.post("/logout");
            },
        }

    }
</script>
