<template>
<guest-login>
    <div v-if="form.errors.email">
        <v-alert type="error">{{ form.errors.email }}</v-alert>
    </div>

    <p class="login-box-msg">Estás a un paso de tu nueva contraseña, confirme su nueva contraseña.</p>
    
    <v-form @submit.prevent="submit">
        <v-text-field v-model="form.password" prepend-inner-icon="mdi-lock" label="Ingrese su clave" outlined dense :error-messages="form.errors.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword">
        </v-text-field>

        <v-text-field v-model="form.password_confirmation" prepend-inner-icon="mdi-lock" label="Confirme su clave" :error-messages="form.errors.password" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword">
        </v-text-field>

        <v-btn :disabled="form.processing" :loading="form.processing" type="submit" block color="primary">Actualizar clave</v-btn>
    </v-form>
</guest-login>
</template>

<script>
import GuestLogin from '../../layouts/GuestLogin.vue';

export default {
    components: { GuestLogin },

    props: {
        email: String,
        token: String
    },
    
    data() {
        return {
            showPassword: false,
            form: this.$inertia.form({
              password: null,
              password_confirmation: null,
              email: this.email,
              token: this.token
            }),
        };
    },
    
    methods: {
        submit() {
            this.form.post("/reset-password");
        },
    },  
}
</script>