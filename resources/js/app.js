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
app.component('images-component', ImagesComponent);
app.component('login-component', LoginComponent);
app.component('registration-component', RegComponent)

app.mount('#app');
