<template>
    <li class="nav-item" @click.prevent="logout">
        <a class="nav-link btn" >
            Выйти
        </a>
    </li>
</template>

<script>
export default {
    name: "LogoutComponent",

    props: [
        'logout_link',
        'login_link'
    ],

    methods: {
        logout() {
            axios.post(this.logout_link)
                .then(response => {
                    localStorage.removeItem('x_xsrf_token')
                    window.location.replace(this.login_link);
                })
        }
    }
}
</script>

<style scoped>

</style>
