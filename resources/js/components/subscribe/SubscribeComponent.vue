<template>
    <div>
    Подписчики: {{ dataSubscribers }}
    </div>
    <div class="row" v-if="!subscribed">
        <button @click.prevent="subscribe" class="btn btn-danger w-25">Подписаться</button>
    </div>
    <div class="row" v-if="subscribed">
        <button class="btn btn-warning w-25">Платная подписка</button><button @click.prevent="subscribe" class="btn btn-secondary w-25">Отписаться</button>
    </div>
</template>

<script>

export default {
    name: "SubscribeComponent",

    data() {
        return {
            sub: false,
            subs: [],
            dataSubscribers: 0
        }
    },

    props: [
        'profile',
        'user',
        'subscribe_on',
    ],

    mounted() {
        this.getSubscribers()
        this.subs = this.subscribe_on
        if(this.sub)
        {
            this.$parent.$data.sub = true
        }
    },

    methods: {
        subscribe() {
            axios.post(`/api/subs/subscribe/${this.profile.id}`)
                .then(response => {
                    this.subs = response.data.data
                    this.sub = !this.sub
                    this.getSubscribers()
                })
        },
        getSubscribers () {
            axios.get(`/api/personal/find?username=${this.profile.username}`)
                .then(response => {

                        this.dataSubscribers = response.data.data[0].subscribers

                })
        }
    },

    computed: {
        subscribed () {
            this.subs.forEach((profile_in_subs) => {

                if (profile_in_subs.id === this.profile.id) {
                    this.sub = true
                }
            })

            return this.sub
        }
    }
}

</script>

<style scoped>

</style>
