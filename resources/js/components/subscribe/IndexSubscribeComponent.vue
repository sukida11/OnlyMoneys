<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "IndexSubscribeComponent",

    data() {
        return {
            subs: []
        }
    },

    props: [
        'profile_link'
    ],

    methods: {
        getSubs() {
            axios.get('/api/personal/subs')
                .then(response => {
                    this.subs = response.data.data
                })
        },
        subscribe(sub_id) {
            axios.post(`/api/subs/subscribe/${sub_id}`)
                .then(response => {
                    this.subs = response.data.data
                })
        },
    },

    mounted() {
        this.getSubs()
    }
})
</script>

<template>
    <div v-if="subs">

        <div class="row">
            <div class="card col-lg-4 m-lg-3" style="width: 18rem;" v-for="sub in subs">
                <div class="card-body">
                    <h5 class="card-title">{{ sub.username }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Подписчиков: {{ sub.subscribers }}</h6>
                    <p class="card-text">{{ sub.bio }}</p>
                    <a :href="`${profile_link}${sub.id}`" class="card-link btn btn-outline-success">Профиль</a>
                    <a href="#" @click.prevent="subscribe(sub.id)" class="card-link btn btn-outline-secondary">Отписаться</a>
                </div>
            </div>
        </div>


    </div>
</template>

<style scoped>

</style>
