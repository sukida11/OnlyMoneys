<template>
    <subscribe-component ref="subscribe" v-bind:subscribe_on="this.subscribe_on" v-bind:profile="this.user"
                         v-bind:user="this.auth_user"></subscribe-component>

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
                    <a href="#" @click.prevent="check_comments(post.id)"><i class="fas fa-message"></i></a>
                </p>
                <div :hidden="!comments(post.id)" class="p-2 mb-3" v-if="comments">
                    <div class="justify-content-center">
                        <a href="#" @click.prevent="drop_comments"><i class="fas fa-xmark"></i></a>
                    </div>
                    <div class="d-flex">
                        <input v-model="message_content" type="text" class="form-control w-25">
                        <button @click.prevent="create_comment" class="btn btn-outline-success">Отправить</button>
                    </div>
                    <div class="mt-2 mb-2" v-for="comment in postComments">
                        <p>
                            {{  comment.username }}:
                            <strong>
                            {{comment.content}}
                        </strong><br>
                            {{ comment.created_at }}
                        </p>
                        <div v-if="comment.username === auth_user.username">
                            <a href="#" @click.prevent="deleteComment(comment.id)"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
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
            post_comment: null,
            message_content: null,
            postComments: []
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

        if (this.user.id === this.auth_user.id) {
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

        like(post_id) {

            axios.post(`/api/show/like/${post_id}`)
                .then(response => {
                    axios.get(`/api/show/load_with_limit/${this.user.id}?limit=${this.count_content - 2}`)
                        .then(response => {
                            this.posts = response.data.data

                        })

                })

        },

        checkContentEnd() {
            if (this.posts.length === Number(this.post_count)) {
                this.post_end = true
            }
        },

        comments(post_id) {
            return this.post_comment === post_id
        },

        check_comments(post_id) {
            this.post_comment = post_id;
            this.get_comments();
        },

        drop_comments() {
            this.post_comment = null;
            this.postComments = []
        },

        get_comments()
        {
            axios.get(`/api/show/comments/${this.post_comment}`)
                .then(response => {
                    this.postComments = response.data.data
                })
        },

        create_comment()
        {
            axios.post('/api/show/comments', {
                content: this.message_content,
                post_id: this.post_comment,
            })
                .then(response => {
                    this.message_content = null
                    this.get_comments()
                })
        },

        deleteComment(comment_id)
        {
            if(confirm('Вы уверены, что хотите удалить этот комментарий?'))
            axios.delete(`/api/show/comments/${comment_id}`)
                .then(response => {
                    this.get_comments()
                })
        }

    },

    computed: {}
}
</script>

<style scoped>

</style>
