<template>
<guest-login>
    <div v-if="status">
        <v-alert type="success">{{ status }}</v-alert>
    </div>

    <p class="login-box-msg">Inicia sesión para comenzar</p>
    <v-form @submit.prevent="login">
        <v-text-field v-model="form.email" prepend-inner-icon="mdi-email" label="Ingrese su correo electrónico" type="email" outlined dense :error-messages="form.errors.email"></v-text-field>
        <v-text-field v-model="form.password" prepend-inner-icon="mdi-lock" label="Ingrese su clave" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" :error-messages="form.errors.password" @click:append="showPassword = !showPassword"></v-text-field>
        <div class="row">
            <div class="col-6 mt-1">
                <div class="icheck-primary">
                    <input v-model="form.remember"  type="checkbox" id="remember">
                    <label for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-6">
                <v-btn color="primary" block class="text-none text-white" :disabled="form.processing" :loading="form.processing" type="submit">Iniciar sesión</v-btn>
            </div>
        </div>
    </v-form>
    <div class="social-auth-links text-center mt-2 mb-3">
        <v-btn color="primary" block class="text-none text-white"><i class="fab fa-facebook mr-2"></i> Iniciar sesión con Facebook</v-btn>
        <v-btn color="error" block class="text-none mt-2 text-white"><i class="fab fa-google-plus mr-2"></i> Iniciar sesión con Google+</v-btn>
    </div>
    <p class="mb-1">
        <Link :href="route('password.request')">Olvidé mi clave!</Link>
    </p>
    <p class="mb-0">
        <Link :href="route('register')" class="text-center">Registrar una nueva membresía</Link>
    </p>
</guest-login>
</template>

<script>
import GuestLogin from '../../layouts/GuestLogin.vue';

export default {
    components: { GuestLogin },
    props: { status: String },

    data() {
        return {
            showPassword: false,
            form: this.$inertia.form({
                email: null,
                password: null,
                remember: false,
            }),
        };
    },
    methods: {
        login() {
            this.form.post("/login");
        },
    }
}
</script>