<template>
<admin>
    <v-card outlined>
        <v-card-title class="py-0 my-0" style="border-bottom: 0.1px solid #B0BEC5 ;">
            <v-col>
                <span class="headline">Datos usuario</span>
                <Link :href="route('users.index')">
                    <v-btn absolute right color="primary">
                        <v-icon class="mr-2">mdi-arrow-left</v-icon>
                        Regresar
                    </v-btn>
                </Link>
            </v-col>
        </v-card-title>

        <v-card-text>
            <v-row class="py-3">
                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-card outlined>
                        <v-card-title class="blue lighten-1 py-1">
                            <span class="subtitle-1 text-white ml-auto mr-auto">Información personal</span>
                        </v-card-title>

                        <v-card-text>
                            <v-row>
                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Nombres:</v-subheader>
                                        </v-col>
                                        <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                            <v-text-field append-icon="fas fa-user" dense outlined class="input_form icons_formularios" :value="user.name" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Apellidos:</v-subheader>
                                        </v-col>
                                        <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                            <v-text-field append-icon="fas fa-user" dense outlined class="input_form icons_formularios" :value="user.lastname" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>


                            <v-row>
                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Dirección:</v-subheader>
                                        </v-col>
                                        <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                            <v-text-field append-icon="fas fa-home" dense outlined class="input_form icons_formularios" :value="user.direction" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Teléfono:</v-subheader>
                                        </v-col>
                                        <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                            <v-text-field append-icon="fas fa-phone-alt" dense outlined class="input_form icons_formularios" :value="user.phone" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Correo:</v-subheader>
                                        </v-col>
                                        <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                            <v-text-field append-icon="fas fa-at" dense outlined class="input_form icons_formularios" :value="user.email" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col class="mb-0 pb-0" cols="12" sm="6" md="12" lg="12" xl="12">
                                    <v-row class="pt-3">
                                        <v-col cols="4" sm="4" md="4" lg="4" xl="4">
                                            <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Fecha de creación:</v-subheader>
                                        </v-col>
                                        <v-col cols="8" sm="8" md="8" lg="8" xl="8">
                                            <v-text-field append-icon="fas fa-user-circle" dense outlined class="input_form icons_formularios" :value="user.created_at" hide-details readonly>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-card outlined>
                        <v-card-title class="blue lighten-1 py-1">
                            <span class="subtitle-1 text-white ml-auto mr-auto">
                                Lista de permisos por roles de usuario
                            </span>
                       </v-card-title>

                        <v-card-text class="pt-1">
                            <v-data-table
                                :headers="headers"
                                :items="arrRoles"
                                :hide-default-footer="true"
                                disable-pagination
                                show-expand
                                no-data-text="Lo sentimos, no hay nada para mostrar aquí">

                                <template v-slot:expanded-item="{ item }">
                                    <td colspan="2" class="py-3">
                                        <th>Nombre del permiso</th>
                                        <hr>
                                        <div class="d-flex flex-column">
                                            <span v-for="(item1, index) in item.permissions" :key="index">
                                                {{ item1.name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td colspan="2" class="py-3">
                                        <th>Descripción del permiso</th>
                                        <hr>
                                        <div class="d-flex flex-column">
                                            <span v-for="(item1, index) in item.permissions" :key="index">
                                                {{ item1.description }}
                                            </span>
                                        </div>
                                    </td>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>

                    <v-card outlined class="mt-5">
                        <v-card-title class="blue lighten-1 py-1">
                            <span class="subtitle-1 text-white ml-auto mr-auto">Permisos</span>
                            <template v-if="auth.permission.includes('users.permissions')">
                                <Link :href="route('users.permissions', {id: user.id})">
                                    <v-btn small color="primary" class="mb-1">
                                        <v-icon>mdi-plus-circle-outline</v-icon>
                                    </v-btn>
                                </Link>
                            </template>
                        </v-card-title>
                        <v-card-text>
                            <v-simple-table height="400px">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="arrPermissions.length > 0">
                                    <tr v-for="(item, index) in arrPermissions" :key="index">
                                            <td v-text="item.name"></td>
                                            <td v-text="item.description"></td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="2">
                                                <v-alert class="mt-5" outlined dense type="info">
                                                    Este usuario no tiene permisos registrados.
                                                </v-alert>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </v-simple-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</admin>
</template>
<script>
import Admin from '../../layouts/Admin.vue';

export default {
    components: { Admin },
    
    props: ["user", "user_permission", "user_permissions_by_role", "auth"],

    data(){
        return {
            headers: [
                {text: 'Nombre del rol', value: 'name', sortable: false},
                {text: 'Descripción del rol', value: 'description', sortable: false},
            ],

            arrRoles: this.user.roles,
            arrPermissions: this.user.permissions
        }
    },

    methods: {

    }
    
}
</script>