<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/img/AdminLTELogo.png" alt="Sistema Laravel y Vue" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Sistema Laravel</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <v-avatar color="rgb(240, 233, 233)" size="33">
                        <span class="rgb(139, 93, 93)" v-text="auth.user.name.charAt(0)+auth.user.lastname.charAt(0)"></span>
                    </v-avatar>
                    <!-- <img :src="ruta+'/img/user2-160x160.jpg'" class="img-circle elevation-2" alt="User Image"> -->
                </div>
                <div class="info" style="background: none !important">
                    <a href="#" class="d-block" v-text="auth.user.name.split(' ', 1)+ ' ' +auth.user.lastname"></a>
                </div>
            </div>

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image" style="background: none !important">
                    <a href="#" class="d-block" @click.prevent="logout">
                        <i class="fas fa-sign-out-alt ml-3 mt-2"></i>
                    </a>
                </div>

                <div class="info" style="background: none !important">
                    <a href="#" class="d-block" @click.prevent="logout">
                        Cerrar sesión
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column ml-0 pl-0" data-widget="treeview" role="menu" data-accordion="false">

                    <template v-if="auth.permission.includes('dashboard.index')">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('home')" :class="route().current('home') ? 'active' : ''">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </Link>
                        </li>
                    </template>

                    <li class="nav-item">
                        <Link class="nav-link" :href="route('digimon.index')" :class="route().current('digimon.index') ? 'active' : ''">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Digimon</p>
                        </Link>
                    </li>

                    <li class="nav-header">ADMINISTRACIÓN</li>

                    <template v-if="auth.permission.includes('users.index')">
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('users.index')" :class="route().current('users.index') || route().current('users.show') || route().current('users.permissions')? 'active' : ''">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Usuarios</p>
                                </Link>
                            </li>
                    </template>

                    <template v-if="auth.permission.includes('roles.index')">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('roles.index')" :class="route().current('roles.index')  || route().current('roles.create') || route().current('roles.edit') ? 'active' : ''">
                                <i class="nav-icon fas fa-unlock-alt"></i>
                                <p>Roles</p>
                            </Link>
                        </li>
                    </template>
                    
                    <template v-if="auth.permission.includes('permissions.index')">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('permissions.index')" :class="route().current('permissions.index') ? 'active' : ''">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Permisos</p>
                            </Link>
                        </li>
                    </template>

                    <template v-if="auth.permission.includes('profile.index')">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('profile.index')" :class="route().current('profile.index') ? 'active' : ''">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </Link>
                        </li>
                    </template>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
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

