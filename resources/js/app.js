/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
const app = createApp({});


import ImagesComponent from "./components/ImagesComponent.vue";
import LoginComponent from "./components/login/LoginComponent.vue";
import RegComponent from "./components/registration/RegComponent.vue";
import IndexComponent from "./components/posts/IndexComponent.vue";
import UpdateComponent from "./components/posts/UpdateComponent.vue";
import LogoutComponent from "./components/logout/LogoutComponent.vue";
app.component('images-component', ImagesComponent);
app.component('login-component', LoginComponent);
app.component('registration-component', RegComponent)
app.component('index-post-component', IndexComponent)
app.component('update-post-component', UpdateComponent)
app.component('logout-component', LogoutComponent)

app.mount('#app');
