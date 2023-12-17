<template>
<adnin>
    <v-card outlined>
        <v-card-title class="pb-0 mb-0 grey lighten-4">
            <h3 class="text-muted mb-3 d-sm-flex d-md-none ml-auto mr-auto">Permisos</h3>
            <v-row class="fill-height" no-gutters>
            <v-col cols="12" class="d-flex mb-2">
                <h3 class="text-muted mt-1 mr-2 d-none d-md-flex d-sm-none d-md-flex">Permisos</h3>
                <v-text-field
                v-model.lazy="search"
                append-icon="mdi-magnify"
                label="Buscar permisos"
                dense
                hide-details
                outlined>
                </v-text-field>

                <template v-if="auth.permission.includes('permissions.create')">
                    <v-btn color="primary" class="ml-2 button_add d-none d-sm-none d-md-flex" @click="OpenDialog">
                    AGREGAR PERMISO<v-icon class="ml-1">mdi-arrow-right</v-icon>
                    </v-btn>
                </template>

                <v-tooltip left>
                <template v-if="auth.permission.includes('permissions.create')" v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" class=" ml-2 button_add d-sm-flex d-md-none" v-bind="attrs" v-on="on" @click="OpenDialog">
                        <v-icon>mdi-plus-circle-outline</v-icon>
                    </v-btn>
                </template>
                <span>Agregar permiso</span>
                </v-tooltip>
            </v-col>
            </v-row>
        </v-card-title>

        <v-data-table
            :items="permissions.data"
            :headers="headers"
            :header-props="{ sortByText: 'Ordenar por' }"
            :options.sync="options"
            :server-items-length="permissions.total"
            :loading="isLoadingTable"
            class="elevation-1"
            no-data-text="Lo sentimos, no hay nada para mostrar aquí"
            dense
            sortByText="Ordenar por"
            loading-text="Cargando... Espere por favor"
            :footer-props="{
            'items-per-page-options' : [15, 25, 35, 45, 75, 150],
            'show-current-page': true,
            'show-first-last-page': true,
            'items-per-page-text': 'Filas por página',
            }">

            <template v-slot:[`item.id`]="{ item }">
                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('permissions.edit')" v-slot:activator="{ on, attrs }">
                        <v-icon small color="lime" class="mr-2" v-bind="attrs" v-on="on" @click.prevent="EditPermission(item)">mdi-pencil</v-icon>
                    </template>
                    <span>Editar permiso</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('permissions.delete')" v-slot:activator="{ on, attrs }">
                        <v-icon small color="red" v-bind="attrs" v-on="on" @click.prevent="DeletePermission(item.id)">mdi-delete</v-icon>
                    </template>
                    <span>Eliminar permiso</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" max-width="650px" style="z-index: 9999;">
        <v-card>
            <v-card-title class="mb-2 grey lighten-4" style="border-bottom: 1px solid #B0BEC5 !important;">
                <span class="headline">{{ formTitle }}</span>
                <v-btn icon white outlined top absolute right @click="CloseDialog">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text class="pt-4">
                <v-form>
                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Nombre:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.name" label="Escriba el nombre del permiso" append-icon="fas fa-user-lock" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.name" hint="Por ejemplo, profile.index">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Descripción:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.description" label="Escriba la descripción del permiso a crear" append-icon="fas fa-user-lock" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.description" hint="Por ejemplo, permiso encargado de permitir revisar el perfil de usuario">
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-card-actions class="mt-0 pt-0 py-3">
                <v-btn color="primary" block :disabled="form.processing" :loading="form.processing" @click.prevent="SubmitPermission">
                    <v-icon left>mdi-content-save</v-icon>
                    {{ buttonTitle }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</adnin>
</template>
<script>
import Adnin from '../../layouts/Admin.vue';

export default {
    components: { Adnin },

    props: ["permissions", "auth"],


    data() {
        return {
            headers: [
                { text: "Nombre del permiso", value: "name" },
                { text: "Descripción del permiso", value: "description" },
                { text: "Fecha de creación", value: "created_at" },
                {text: 'Acciones', value: 'id', sortable: false}
            ],

            dialog: false,

            isUpdate: false,
            show_comfirmpassword: false,
            showPassword: false,

            isLoadingTable: false,

            options: {},
            search: null,
            params: {},

            itemId: null,
            form: this.$inertia.form({
                name: null,
                description: null,
            }),
        };
    },

    computed: {
        formTitle() {
            return this.isUpdate ? "Editar Permiso" : "Crear Permiso";
        },

        buttonTitle(){
            return this.isUpdate ? "Actualizar permiso" : "Registrar permiso";
        }
    },
  
    watch: {
        options: function (valor){
            this.params.sortBy = valor.sortBy[0];
            this.params.sortDesc = valor.sortDesc[0];
            this.params.page = valor.page;
            this.params.itemsPerPage = valor.itemsPerPage;

            this.getListarPermisos();
        },

        search: function (valor) {
            this.options.page = 1;
            this.params.page = 1;
            this.params.search = valor;
            this.getListarPermisos();
        },
    },

    methods: {
        getListarPermisos() {
            this.isLoadingTable = true
            this.$inertia.get("/permissions", this.params, {
                preserveState: true,
                preverseScroll: true,
                onSuccess: () => {
                this.isLoadingTable = false
                },
            });
        },

        OpenDialog() {
            this.dialog = true;
        },

        CloseDialog(){
            Fire.$emit('AfterAddPermission');
        },

        EditPermission(item) {
            this.form.clearErrors();
            this.form.name = item.name;
            this.form.description = item.description;
            this.isUpdate = true;
            this.itemId = item.id;
            this.dialog = true;
        },

        SubmitPermission() {
            if (this.isUpdate) {
                this.form.put(route("permissions.update", this.itemId), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        Fire.$emit('AfterAddPermission');
                    },
                });
            }else{
                this.form.post(route("permissions.store"), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        Fire.$emit('AfterAddPermission');
                    },
                });
            }
        },

        DeletePermission(item){
            this.$confirm('No podrás revertir esto!', '¿Está seguro?', {
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning',
                closeOnClickModal: false,
                closeOnPressEscape: true
            }).then(() => {
                this.form.delete(route("permissions.destroy", item), {
                    preverseScroll: true,
                });
            }).catch(() => {
                this.$notify({
                    title: 'Cancelado',
                    type: 'info',
                    message: 'Eliminación cancelada',
                    duration: 1500
                });
            });
        }
    },

    created(){
        Fire.$on('AfterAddPermission', () => {
            this.getListarPermisos();
            this.dialog = false;
            this.itemId = null;
            this.form.reset();
            this.form.clearErrors();
            this.isUpdate = false;
        });
    }
}
</script>