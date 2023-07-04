<template>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Вход</div>

                <div class="card-body">
                    <form method="POST">

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Логин</label>

                            <div class="col-md-6">
                                <input id="username" v-model="username" type="text" class="form-control" name="username" required autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>

                            <div class="col-md-6">
                                <input v-model="password" id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="mt-2 mb-2 is-invalid text-danger text-center container-fluid" role="alert">
                                        <strong>{{ message }}</strong>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input v-model="remember" class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button @click.prevent="login" type="submit" class="btn btn-primary">
                                    Войти
                                </button>

                                <a class="btn btn-link" :href="this.password_reset_link">
                                    Забыли пароль?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "LoginComponent",

    data() {
        return {
            username: null,
            password: null,
            remember: null,
            message: null
        }
    },

    props: [
        'password_reset_link',
        'redirect_after_login'
    ],

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    username: this.username,
                    password: this.password,
                    remember: this.remember
                })
                    .then(response => {
                        localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN'])
                        window.location.replace(this.redirect_after_login);
                    })
                    .catch(error => {
                        this.message = error.response.data.message;
                    })
            });
        }
    }
}
</script>

<style scoped>

</style>
