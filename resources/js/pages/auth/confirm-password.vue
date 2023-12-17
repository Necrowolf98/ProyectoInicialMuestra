<template>
<guest-login>
    <p class="login-box-msg">Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.</p>

    <v-form @submit.prevent="submit">
        <v-text-field v-model="form.password" prepend-inner-icon="mdi-lock" label="Ingrese su clave" outlined dense :error-messages="form.errors.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword"></v-text-field>

        <v-btn :disabled="form.processing" :loading="form.processing" type="submit" block color="primary">Ingresar</v-btn>
    </v-form>
</guest-login>
</template>

<script>
import GuestLogin from '../../layouts/GuestLogin.vue';

export default {
    components: { GuestLogin },
    data() {
        return {
            showPassword: false,
            isLoading: false,
            form: this.$inertia.form({
                password: null
            }),
        };
    },
    
    methods: {
        submit() {
            this.form.post(this.route('password.confirm'));
        },
    },
};
</script>
