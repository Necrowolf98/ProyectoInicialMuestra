<template>
<v-app>
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <Link :href="route('/')" class="h1"><b>Admin</b>LTE</Link>
                </div>

                <div class="card-body">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</v-app>
</template>
<script>

export default {

}
</script>
 