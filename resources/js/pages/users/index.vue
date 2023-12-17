<template>
<admin>
    <v-card outlined>
        <v-card-title class="pb-0 mb-0 grey lighten-4">
            <h3 class="text-muted mb-3 d-sm-flex d-md-none ml-auto mr-auto">Usuarios</h3>
            <v-row class="fill-height" no-gutters>
            <v-col cols="12" class="d-flex mb-2">
                <h3 class="text-muted mt-1 mr-2 d-none d-md-flex d-sm-none d-md-flex">Usuarios</h3>
                <v-text-field
                v-model.lazy="search"
                append-icon="mdi-magnify"
                label="Buscar usuarios"
                dense
                hide-details
                outlined>
                </v-text-field>

                <template v-if="auth.permission.includes('users.create')">
                    <v-btn color="primary" class="ml-2 button_add d-none d-sm-none d-md-flex" @click="OpenDialog">
                    AGREGAR USUARIO<v-icon class="ml-1">mdi-arrow-right</v-icon>
                    </v-btn>
                </template>

                <v-tooltip left>
                <template v-if="auth.permission.includes('users.create')" v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" class=" ml-2 button_add d-sm-flex d-md-none" v-bind="attrs" v-on="on" @click="OpenDialog">
                        <v-icon>mdi-plus-circle-outline</v-icon>
                    </v-btn>
                </template>
                <span>Agregar usuario</span>
                </v-tooltip>
            </v-col>
            </v-row>
        </v-card-title>

        <v-data-table
            :items="users.data"
            :headers="headers"
            :header-props="{ sortByText: 'Ordenar por' }"
            :options.sync="options"
            :server-items-length="users.total"
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

            <template v-slot:[`item.lastname`]="{ item }">
                <span v-text="item.lastname +' '+ item.name.split(' ', 1)"></span>
            </template>

            <template v-slot:[`item.role_name`]="{ item }">
                <div class="d-flex flex-column">
                    <span v-for="(role, index) in item.roles" :key="index">
                        {{ role.name }}
                    </span>
                </div>
            </template>

            <template v-slot:[`item.id`]="{ item }">
                <v-tooltip bottom>
                <template v-if="auth.permission.includes('users.show')" v-slot:activator="{ on, attrs }">
                    <Link :href="route('users.show', { id: item.id })">
                        <v-icon small color="primary" class="mr-2" v-bind="attrs" v-on="on">mdi-eye</v-icon>
                    </Link>
                </template>
                <span>Ver usuario</span>
            </v-tooltip>

                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('users.edit')" v-slot:activator="{ on, attrs }">
                        <v-icon small color="lime" class="mr-2" v-bind="attrs" v-on="on" @click.prevent="EditUser(item)">mdi-pencil</v-icon>
                    </template>
                    <span>Editar usuario</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('users.delete')" v-slot:activator="{ on, attrs }">
                        <v-icon small color="red" v-bind="attrs" v-on="on" @click.prevent="DeleteUser(item.id)">mdi-delete</v-icon>
                    </template>
                    <span>Eliminar usuario</span>
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
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Nombres:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.name" label="Escriba los nombres del usuario" append-icon="fas fa-user" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.name" hint="Por ejemplo, Mauricio Antonio">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Apellidos:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.lastname" label="Escriba los apellidos del usuario" append-icon="fas fa-user" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.lastname" hint="Por ejemplo, Cevallos Andrade">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Dirección:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.direction" label="Escriba la dirección del usuario" append-icon="fas fa-home" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.direction" hint="Por ejemplo, Las piñas">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Correo:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.email" label="Escriba el correo del usuario" append-icon="fas fa-at" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.email" hint="Por ejemplo, ejemplo@gmail.com">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Celular:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.phone" label="Escriba el email del usuario" append-icon="fas fa-phone-alt" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.phone" hint="Por ejemplo, 099 998 4128">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row v-if="auth.roles.includes('Administrador')">
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Clave:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.password" label="Escriba la clave del usuario" prepend-inner-icon="mdi-lock" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword" >
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row v-if="auth.roles.includes('Administrador')">
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Confirmar clave:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-text-field v-model="form.password_confirmation" label="Escriba la clave confirmación del usuario" prepend-inner-icon="mdi-lock" dense outlined class="input_form icons_formularios my-0 py-0" :error-messages="form.errors.password" :append-icon="show_comfirmpassword ? 'mdi-eye' : 'mdi-eye-off'" :type="show_comfirmpassword ? 'text' : 'password'" @click:append="show_comfirmpassword = !show_comfirmpassword" >
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row v-if="auth.roles.includes('Administrador')">
                        <v-col sm="4" md="3" lg="3" xl="3" class="my-0 py-0 px-0">
                            <v-subheader class="sub_header_form float-right mx-0 px-0">Rol:</v-subheader>
                        </v-col>
                        <v-col sm="8" md="9" lg="9" xl="9" class="my-0 py-0">
                            <v-select v-model="form.role_id" label="Seleccione el rol del usuario" :items="roles"
                            item-text="name" return-object multiple dense outlined append-icon="fas fa-user-tag" class="input_form icons_formularios input_form_select my-0 py-0"
                            :error-messages="form.errors.role_id" hint="Por ejemplo, administrador" clearable>
                            </v-select>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-card-actions class="mt-0 pt-0 py-3">
                <v-btn color="primary" block :disabled="form.processing" :loading="form.processing" @click.prevent="SubmitUser">
                    <v-icon left>mdi-content-save</v-icon>
                    {{ buttonTitle }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</admin>
</template>

<script>
import Admin from "../../layouts/Admin.vue";

export default {
    components: { Admin },
    
    props: ["users", "roles", "auth"],

    data() {
        return {
            headers: [
                { text: "Usuario", value: "lastname" },
                { text: "Celular", value: "phone" },
                { text: "Correo", value: "email" },
                {text: 'Roles', value: 'role_name'},
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
                lastname: null,
                direction: null,
                email: null,
                phone: null,
                password: null,
                password_confirmation: null,
                role_id: [],
            }),
        };
    },

    computed: {
        formTitle() {
            return this.isUpdate ? "Editar Usuario" : "Crear Usuario";
        },

        buttonTitle(){
            return this.isUpdate ? "Actualizar usuario" : "Registrar usuario";
        }
    },
  
    watch: {
        options: function (valor){
            this.params.sortBy = valor.sortBy[0];
            this.params.sortDesc = valor.sortDesc[0];
            this.params.page = valor.page;
            this.params.itemsPerPage = valor.itemsPerPage;

            this.getListarUsuarios();
        },

        search: function (valor) {
            this.options.page = 1;
            this.params.page = 1;
            this.params.search = valor;
            this.getListarUsuarios();
        },
    },

    methods: {
        getListarUsuarios() {
            this.isLoadingTable = true
            this.$inertia.get("/users", this.params, {
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
            Fire.$emit('AfterAddUser');
        },

        EditUser(item) {
            this.form.clearErrors();
            this.form.name = item.name;
            this.form.lastname = item.lastname;
            this.form.direction = item.direction;
            this.form.email = item.email;
            this.form.phone = item.phone;
            this.isUpdate = true;
            this.itemId = item.id;
            this.form.role_id = item.roles;
            this.dialog = true;
        },

        SubmitUser() {
            if (this.isUpdate) {
                this.form.put(route("users.update", this.itemId), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        Fire.$emit('AfterAddUser');
                    },
                });
            }else{
                this.form.post(route("users.store"), {
                    preverseScroll: true,
                    onSuccess: () => {
                        this.isLoading = false;
                        Fire.$emit('AfterAddUser');
                    },
                });
            }
        },

        DeleteUser(item){
            this.$confirm('No podrás revertir esto!', '¿Está seguro?', {
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning',
                closeOnClickModal: false,
                closeOnPressEscape: true
            }).then(() => {
                this.form.delete(route("users.destroy", item), {
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
        Fire.$on('AfterAddUser', () => {
            this.getListarUsuarios();
            this.dialog = false;
            this.itemId = null;
            this.form.reset();
            this.form.clearErrors();
            this.isUpdate = false;
        });
    }
};
</script>
