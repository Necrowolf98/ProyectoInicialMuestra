<template>
<admin>
    <v-card outlined>
        <v-card-title class="py-0 my-0" style="border-bottom: 0.1px solid #B0BEC5 ;">
            <v-col>
                <span class="headline">Editar datos del perfil</span>
            </v-col>
        </v-card-title>

        <v-card-text class="pt-4">
            <v-form>
                <v-row>
                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Nombres:</v-subheader>
                            </v-col>
                            <v-col cols="10" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                <v-text-field v-model="form.name" label="Nombres del usuario" append-icon="fas fa-user-alt" dense outlined class="input_form icons_formularios" :error-messages="form.errors.name">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Apellidos</v-subheader>
                            </v-col>
                            <v-col cols="10" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                <v-text-field v-model="form.lastname" label="Apellidos del usuario" append-icon="fas fa-user-alt" dense outlined class="input_form icons_formularios" :error-messages="form.errors.lastname">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Dirección:</v-subheader>
                            </v-col>
                            <v-col cols="10" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                <v-text-field v-model="form.direction" label="Dirección del usuario" append-icon="fas fa-road" dense outlined class="input_form icons_formularios" :error-messages="form.errors.direction">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Correo</v-subheader>
                            </v-col>
                            <v-col cols="10" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                <v-text-field v-model="form.email" label="Correo del usuario" append-icon="fas fa-at" dense outlined class="input_form icons_formularios" :error-messages="form.errors.email">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Teléfono:</v-subheader>
                            </v-col>
                            <v-col cols="9" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                  <v-text-field v-model="form.phone" label="Teléfono del usuario" append-icon="fas fa-phone-alt" dense outlined class="input_form icons_formularios" :error-messages="form.errors.phone">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="3" md="3" lg="3" xl="3">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Creado el:</v-subheader>
                            </v-col>
                            <v-col cols="9" sm="9" md="9" lg="9" xl="9" class="pb-0 mb-0">
                                  <v-text-field v-model="created_at" label="Fecha de creación" readonly append-icon="far fa-calendar-alt" dense outlined class="input_form icons_formularios">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="2" md="2" lg="2" xl="2">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Clave:</v-subheader>
                            </v-col>
                            <v-col cols="9" sm="10" md="10" lg="10" xl="10" class="pb-0 mb-0">
                                <v-text-field v-model="form.password" prepend-inner-icon="mdi-lock" label="Cambio de clave" class="input_form icons_formularios" outlined dense :error-messages="form.errors.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col class="mb-0 pb-0" cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-row class="pt-3">
                            <v-col cols="2" sm="3" md="3" lg="3" xl="3">
                                <v-subheader class="sub_header_form float-md-right float-lg-right float-xl-right text-muted mx-0 px-0">Confirmar clave</v-subheader>
                            </v-col>
                            <v-col cols="9" sm="9" md="9" lg="9" xl="9" class="pb-0 mb-0">
                                <v-text-field v-model="form.password_confirmation" prepend-inner-icon="mdi-lock" label="Confirmación de cambio de clave" :error-messages="form.errors.password" class="input_form icons_formularios"  outlined dense :append-icon="show_comfirmpassword ? 'mdi-eye' : 'mdi-eye-off'" :type="show_comfirmpassword ? 'text' : 'password'" @click:append="show_comfirmpassword = !show_comfirmpassword">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>

        <v-card-actions>
            <v-col cols="3" class="py-0 my-0">
                <v-btn :disabled="form.processing" :loading="form.processing" @click.prevent="UpdateProfile" block color="primary" class="mt-3">Actualizar perfil</v-btn>
            </v-col>
        </v-card-actions>
    </v-card>
</admin>
</template>

<script>
import Admin from "../../layouts/Admin.vue";

export default {   
    components: { Admin },
    
    props: ["auth"],

    data() {
        return {
            show_comfirmpassword: false,
            showPassword: false,
            isLoading: false,

            created_at: this.auth.user.created_at,
            
            form: this.$inertia.form({
                name: this.auth.user.name,
                lastname: this.auth.user.lastname,
                direction: this.auth.user.direction,
                email: this.auth.user.email,
                phone: this.auth.user.phone,
                password: null,
                password_confirmation: null,
            }),
        };
    },

    methods: {
        UpdateProfile() {
            this.form.put(route("profile.update", this.auth.user.id), {
                preverseScroll: true,
                onSuccess: () => {
                    this.isLoading = false;
                    this.form.password = null;
                    this.form.password_confirmation = null;
                },
            });
        }
    },
};
</script>
