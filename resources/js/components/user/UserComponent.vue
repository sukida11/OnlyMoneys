<template >
    <subscribe-component ref="subscribe" v-bind:subscribe_on="this.subscribe_on" v-bind:profile="this.user" v-bind:user="this.auth_user"></subscribe-component>

    <div class="mt-5" v-if="posts">
        <div v-for="post in posts">
            <template v-if="true">
            <p v-if="user.id !== post.user.id">{{ post.user.username }}</p>
            <h5>{{ post.content }}</h5>
            <div class="d-flex mt-2 mb-2" style="width: 100px ; height: 100px">
                <img v-for="image in post.images" :src="image.url" alt="">
            </div>
            <p>
                {{ post.created_at }}
            </p>
            <p>
                <a v-if="post.liked" @click.prevent="like(post.id)" href="" class=""><i
                    class="fas fa-heart"></i></a>
                <a v-if="!post.liked" @click.prevent="like(post.id)" href="#" class=""><i class="far fa-heart"></i></a>
                {{ post.likes }}
            </p>
            <hr>
            </template>
        </div>

        <button v-if="!post_end" @click.prevent="load_content" class="btn btn-outline-secondary">Загрузить ещё</button>
    </div>
</template>

<script>
import SubscribeComponent from "../../components/subscribe/SubscribeComponent.vue";
export default {
    name: "IndexComponent",

    components: {SubscribeComponent},

    data() {
        return {
            posts: [],
            count_content: null,
            post_end: false,
            offset: 0,
            payed_subscriber: false,
            sub: false,
        }
    },

    props: [
        'user',
        'content_per_page',
        'liked_posts',
        'auth_user',
        'user_personal_link',
        'subscribe_on',
        'subscribers',
        'post_count'
    ],

    updated() {
        this.checkContentEnd()
    },

    mounted() {
        this.dataSubscribers = this.subscribers

        if(this.user.id === this.auth_user.id)
        {
            window.location.replace(this.user_personal_link)
        }

        this.count_content = Number(this.content_per_page)
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get(`/api/show/${this.user.id}?count_content=${this.count_content}`)
                .then(response => {

                    this.posts = response.data.data
                    this.count_content += Number(this.content_per_page)
                })
        },

        load_content() {

            axios.get(`/api/show/${this.user.id}?count_content=${this.count_content}`)
                .then(response => {
                    if (response.data.data.length !== 0) {

                        response.data.data.forEach(post => {


                            this.posts.push(post)

                        })
                        this.count_content += Number(this.content_per_page)
                    }

                })

        },

        postLike(post) {
            console.log(post);
            return this.liked_posts.find((postToFind) => postToFind.id === post.id);
        },

        like(post_id) {

            axios.post(`/api/show/like/${post_id}`)
                .then(response => {
                    axios.get(`/api/show/load_with_limit/${this.user.id}?limit=${this.count_content-2}`)
                        .then(response => {
                            this.posts = response.data.data

                        })

                })

        },

        checkContentEnd()
        {
            if(this.posts.length === Number(this.post_count))
            {
                this.post_end = true
            }
        }

    },

    computed: {

    }
}
</script>

<style scoped>

</style>
