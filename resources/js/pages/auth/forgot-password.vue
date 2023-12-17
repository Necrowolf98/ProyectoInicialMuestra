<template>
<guest-login>
    <div v-if="status">
        <v-alert type="success">{{ status }}</v-alert>
    </div>
    
    <p class="login-box-msg">¿Olvidaste tu clave? Aquí puedes solicitar facilmente una nueva clave.</p>
    
    <v-form @submit.prevent="submit">
        <v-text-field v-model="form.email" prepend-inner-icon="mdi-email" label="Ingrese su correo electrónico" type="email" outlined dense :error-messages="form.errors.email"></v-text-field>
        <v-btn :disabled="form.processing" :loading="form.processing" type="submit" block color="primary">Solicitar una nueva clave</v-btn>
    </v-form>
</guest-login>
</template>

<script>
import GuestLogin from '../../layouts/GuestLogin.vue';

export default {
    components: { GuestLogin },
    props: { status: String },
    
    data() {
        return {
            form: this.$inertia.form({
                email: null,
            }),
        };
    },
    
    methods: {
        submit() {
            this.form.post("/forgot-password");
        },
    },  
}
</script>