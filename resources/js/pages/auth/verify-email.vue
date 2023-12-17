<template>
<guest-login>
    <div v-if="status">
        <v-alert type="success">{{ status }}</v-alert>
    </div>

    <p class="login-box-msg text-justify">
        Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibiste el correo electrónico, con gusto te enviaremos otro.
    </p>

    <v-form @submit.prevent="submit">
        <v-btn :disabled="form.processing" :loading="form.processing" type="submit" block color="primary">Solicitar enlace de verificación</v-btn>
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
            this.form.post(this.route('verification.send'));
        },
    },  
}
</script>