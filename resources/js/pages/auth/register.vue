<template>
<v-app>
    <div class="register-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <Link :href="route('/')" class="h1"><b>Admin</b>LTE</Link>
                </div>
                <div class="card-body">
                    <p class="login-box-msg p-0">Registrar una nueva membresía</p>
                    <v-form @submit.prevent="register">
                        <v-text-field class="input_form" v-model="form.name" prepend-inner-icon="mdi-account" label="Ingrese sus nombres" outlined dense type="text" :error-messages="form.errors.name">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.lastname" prepend-inner-icon="mdi-account" label="Ingrese sus apellidos" outlined dense type="text" :error-messages="form.errors.lastname">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.direction" prepend-inner-icon="fas fa-road" label="Ingrese su dirección" outlined dense type="text" :error-messages="form.errors.direction">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.email" prepend-inner-icon="mdi-email" label="Ingrese su correo" type="Ingrese su email" outlined dense :error-messages="form.errors.email">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.phone" prepend-inner-icon="fas fa-phone-alt" label="Ingrese su teléfono" outlined dense type="text" :error-messages="form.errors.phone">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.password" prepend-inner-icon="mdi-lock" label="Ingrese su clave" outlined dense :error-messages="form.errors.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword">
                        </v-text-field>

                        <v-text-field class="input_form" v-model="form.password_confirmation" prepend-inner-icon="mdi-lock" label="Confirme su clave" :error-messages="form.errors.password" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword">
                        </v-text-field>

                        <v-btn :disabled="form.processing" :loading="form.processing" type="submit" block color="primary" class="my-2">Registrarse</v-btn>
                    </v-form>

                    <Link :href="route('login')" class="text-center">Tengo una membresia</Link>
                </div>
            </div>
        </div>
    </div>
</v-app>
</template>

<script>
export default {
    data() {
        return {
            showPassword: false,

            form: this.$inertia.form({
                name: null,
                lastname: null,
                direction: null,
                email: null,
                phone: null,
                password: null,
                password_confirmation: null,
            }),
        };
  },
    methods: {
        register() {
            this.form.post("/register");
        },
    },
}
</script>