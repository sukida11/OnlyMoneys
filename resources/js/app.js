import './bootstrap';
import { createApp } from 'vue';
import store from "./store.js";


const app = createApp({});

app.use(store)


import ImagesComponent from "./components/ImagesComponent.vue";
import LoginComponent from "./components/login/LoginComponent.vue";
import RegComponent from "./components/registration/RegComponent.vue";
import IndexComponent from "./components/posts/IndexComponent.vue";
import UpdateComponent from "./components/posts/UpdateComponent.vue";
import LogoutComponent from "./components/logout/LogoutComponent.vue";
import MainComponent from "./components/MainComponent.vue";
import NavbarSearch from "./components/NavbarSearch.vue";
import UserComponent from "./components/user/UserComponent.vue";
import SubscribeComponent from "@/components/subscribe/SubscribeComponent.vue";
import IndexSubscribeComponent from "@/components/subscribe/IndexSubscribeComponent.vue";
app.component('images-component', ImagesComponent);
app.component('login-component', LoginComponent);
app.component('registration-component', RegComponent)
app.component('index-post-component', IndexComponent)
app.component('update-post-component', UpdateComponent)
app.component('logout-component', LogoutComponent)
app.component('main-component', MainComponent)
app.component('navbar-search', NavbarSearch)
app.component('user-component', UserComponent)
app.component('subscribe-component', SubscribeComponent)
app.component('index-subscribe-component', IndexSubscribeComponent)

app.mount('#app');
