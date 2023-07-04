<template>
    <form method="POST">

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" v-model="name" required autocomplete="name" autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="username" class="col-md-4 col-form-label text-md-end">Логин</label>

            <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" v-model="username" required autocomplete="username" autofocus>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">Электронная почта</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" v-model="email" required autocomplete="email">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" v-model="password" name="password" required autocomplete="new-password">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Подтверждение пароля</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="mt-2 mb-2 is-invalid text-danger text-center container-fluid" role="alert">
            <strong>{{ message }}</strong>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary" @click.prevent="registration">
                    Зарегистрироваться
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "RegComponent",

    data() {
        return {
            name: null,
            username: null,
            email: null,
            password: null,
            password_confirmation: null,
            message: null
        }
    },

    props: [
        'redirect_link_after_registration'
    ],

    methods: {
        registration() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                    .then(response => {
                        localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN'])
                        window.location.replace(this.redirect_link_after_registration)
                    })
                    .catch(error => {
                        this.message = error.response.data.message
                    })
            });
        }
    }
}
</script>

<style scoped>

</style>
