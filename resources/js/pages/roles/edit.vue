<template>
<admin>
    <v-card outlined>
        <v-card-title class="py-0 my-0" style="border-bottom: 0.1px solid #B0BEC5 ;">
            <v-col>
                <span class="headline">Edición de roles y permisos</span>
                <Link  :href="route('roles.index')">
                    <v-btn absolute right color="primary">
                        <v-icon class="mr-2">mdi-arrow-left</v-icon>
                            Regresar
                    </v-btn>
                </Link>
            </v-col>
        </v-card-title>

        <v-card-text>
            <v-form>
                <v-row class="py-3">
                    <v-col cols="12" sm="12" md="5" lg="5" xl="5">
                        <v-card outlined>
                            <v-card-title class="blue lighten-1 py-1">
                                <span class="subtitle-1 text-white ml-auto mr-auto">Formulario edición del rol</span>
                            </v-card-title>

                            <v-card-text>
                                <v-row>
                                    <v-col class="mb-0 pb-0" cols="12" sm="5" md="12" lg="12" xl="12">
                                        <v-row class="pt-3">
                                            <v-col cols="3" sm="4" md="3" lg="3" xl="3">
                                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Nombre:</v-subheader>
                                            </v-col>
                                            <v-col cols="9" sm="8" md="9" lg="9" xl="9" class="pb-0 mb-0">
                                                <v-text-field v-model="form.name" label="Escriba el nombre del rol" append-icon="fas fa-unlock-alt" dense outlined class="input_form icons_formularios" hint="Por ejemplo Listar usuarios"  :error-messages="form.errors.name">
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-col>

                                    <v-col class="mb-0 pb-0" cols="12" sm="7" md="12" lg="12" xl="12">
                                        <v-row class="pt-3">
                                            <v-col cols="3" sm="3" md="3" lg="3" xl="3">
                                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Descripción</v-subheader>
                                            </v-col>
                                            <v-col cols="9" sm="9" md="9" lg="9" xl="9">
                                                <v-text-field v-model="form.description" label="Escriba la descripción del rol a crear" append-icon="fas fa-unlock-alt" dense outlined class="input_form icons_formularios" hint="Por ejemplo, rol encargado de controlar las ventas" :error-messages="form.errors.description">
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-card-text>

                            <v-card-actions class="grey lighten-5 py-0 my-0">
                                <v-col cols="6" class="p-0 m-0">
                                    <v-btn color="blue lighten-1" block small class="text-white" :disabled="form.processing" :loading="form.processing" @click.prevent="UpdateRolePermissions">
                                        <v-icon class="mr-1">mdi-content-save</v-icon>
                                        Actualizar
                                    </v-btn>
                                </v-col>

                                <v-col cols="6">
                                    <v-btn color="grey lighten-1" block small class="text-white" @click.prevent="CleanForm">
                                        <v-icon class="mr-1">mdi-alert</v-icon>
                                        Limpiar
                                    </v-btn>
                                </v-col>
                            </v-card-actions>
                        </v-card>
                    </v-col>

                    <v-col cols="12" sm="12" md="7" lg="7" xl="7">
                        <v-card outlined>
                            <v-card-title class="blue lighten-1 py-1">
                                <span class="subtitle-1 text-white ml-auto mr-auto">Listado de permisos</span>
                            </v-card-title>

                            <v-card-text>
                                <v-simple-table height="500px">
                                    <thead>
                                        <tr>
                                            <th>Nombre del rol</th>
                                            <th>Descripción</th>
                                            <th>Fecha de creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in ContenedorPermisos" :key="index">
                                            <td>
                                                <v-checkbox color="info"
                                                :label="item.name"
                                                :value="item"
                                                v-model="form.permissions"
                                                :error-messages="form.errors.permissions"
                                                :value-comparator="comparatorRolesChecked"
                                                @change="checkPermisosByChecked"
                                                ></v-checkbox>
                                            </td>
                                            <td v-text="item.description"></td>
                                            <td v-text="item.created_at"></td>
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
    </v-card>
</admin>
</template>
<script>
import Admin from '../../layouts/Admin.vue';

export default {
    components: { Admin },

    props: ["role", "permissions"],

    data(){
        return {

            ContenedorPermisos: this.permissions,

            itemId: null,
            form: this.$inertia.form({
                name: '',
                description: '',
                permissions: []
            }),
        }
    },

    mounted(){
        this.getRolesByPermissions();
    },

    methods: {
        getRolesByPermissions(){
            this.itemId = this.role.id;
            this.form.name = this.role.name;
            this.form.description = this.role.description;
            this.form.permissions = this.role.permissions;
        },

        UpdateRolePermissions(){
            this.form.put(route("roles.update", this.itemId), {
                preverseScroll: true,
                onSuccess: () => {
                    this.$notify({
                        title: 'Exitoso!',
                        message: 'Se ha actualizado el rol correctamente.',
                        type: 'success',
                        duration: 1500
                    });
                },
                onError: () => {
                    if(this.form.errors.permissions){
                        this.$confirm('Debe seleccionar al menos un permiso!','Oops.', {
                            confirmButtonText: 'Ok',
                            showCancelButton: false,
                            type: 'error',
                            closeOnClickModal: false,
                            closeOnPressEscape: true
                        });
                    }
                }
            });
        },

        checkPermisosByChecked(){
            if(this.form.errors.permissions){
                if(this.form.permissions){
                    this.form.errors.permissions = '';
                }
            }
        },

        comparatorRolesChecked(a, b) {
            return a.id == b.id;
        },

        CleanForm(){
            this.form.reset();
            this.form.clearErrors();
        }

    }
}
</script>