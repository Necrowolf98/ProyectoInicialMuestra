<template>
<admin>
    <v-card outlined>
        <v-card-title class="pb-0 mb-0 grey lighten-4">
            <h3 class="text-muted mb-3 d-sm-flex d-md-none ml-auto mr-auto">Roles</h3>
            <v-row class="fill-height" no-gutters>
            <v-col cols="12" class="d-flex mb-2">
                <h3 class="text-muted mt-1 mr-2 d-none d-md-flex d-sm-none d-md-flex">Roles</h3>
                <v-text-field
                v-model.lazy="search"
                append-icon="mdi-magnify"
                label="Buscar roles"
                dense
                hide-details
                outlined>
                </v-text-field>

                <template v-if="auth.permission.includes('roles.create')">
                    <Link :href="route('roles.create')">
                        <v-btn color="primary" class="ml-2 button_add d-none d-sm-none d-md-flex">
                            AGREGAR ROL<v-icon class="ml-1">mdi-arrow-right</v-icon>
                        </v-btn>
                    </Link>
                </template>

                <v-tooltip left>
                <template v-slot:activator="{ on, attrs }">
                    <Link :href="route('roles.create')">
                        <v-btn color="primary" class=" ml-2 button_add d-sm-flex d-md-none" v-bind="attrs" v-on="on" :href="route('roles.create')">
                            <v-icon>mdi-plus-circle-outline</v-icon>
                        </v-btn>
                    </Link>
                </template>
                <span>Agregar rol</span>
                </v-tooltip>
            </v-col>
            </v-row>
        </v-card-title>

        <v-data-table
            :items="roles.data"
            :headers="headers"
            :header-props="{ sortByText: 'Ordenar por' }"
            :options.sync="options"
            :server-items-length="roles.total"
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

            <template v-slot:[`item.permissions.name`]="{ item }">
                <div class="d-flex flex-column">
                    <span v-for="(permission, index) in item.permissions" :key="index">
                        {{ permission.name }}
                    </span>
                </div>
            </template>

            <template v-slot:[`item.id`]="{ item }">
                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('roles.edit')" v-slot:activator="{ on, attrs }">
                        <Link :href="route('roles.edit', { id: item.id })">
                            <v-icon small color="lime" class="mr-2" v-bind="attrs" v-on="on">mdi-pencil</v-icon>
                        </Link>
                    </template>
                    <span>Editar rol</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <template v-if="auth.permission.includes('roles.delete')" v-slot:activator="{ on, attrs }">
                        <v-icon small color="red" v-bind="attrs" v-on="on" @click.prevent="DeleteRole(item.id)">mdi-delete</v-icon>
                    </template>
                    <span>Eliminar rol</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card>
</admin>
</template>

<script>
import Admin from "../../layouts/Admin.vue";

export default {
    components: { Admin },
    
    props: ["roles", "auth"],

    data() {
        return {
            headers: [
                { text: "Nombre del rol", value: "name" },
                { text: "Descripción del rol", value: "description" },
                {text: 'Permisos del rol', value: 'permissions.name', sortable: false},
                { text: "Fecha de creación", value: "created_at" },
                {text: 'Acciones', value: 'id', sortable: false}
            ],

            isLoadingTable: false,
            options: {},
            search: null,
            params: {},
        };
    },
  
    watch: {
        options: function (valor){
            this.params.sortBy = valor.sortBy[0];
            this.params.sortDesc = valor.sortDesc[0];
            this.params.page = valor.page;
            this.params.itemsPerPage = valor.itemsPerPage;

            this.getListarRoles();
        },

        search: function (valor) {
            this.options.page = 1;
            this.params.page = 1;
            this.params.search = valor;
            this.getListarRoles();
        },
    },

    methods: {
        getListarRoles() {
            this.isLoadingTable = true
            this.$inertia.get("/roles", this.params, {
                preserveState: true,
                preverseScroll: true,
                onSuccess: () => {
                this.isLoadingTable = false
                },
            });
        },

        DeleteRole(item){
            this.$confirm('No podrás revertir esto!', '¿Está seguro?', {
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning',
                closeOnClickModal: false,
                closeOnPressEscape: true
            }).then(() => {
                this.$inertia.delete(route("roles.destroy", item), {
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
    }
};
</script>
