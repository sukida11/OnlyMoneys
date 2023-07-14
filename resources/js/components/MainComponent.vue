<template>
    <div class="mt-5" v-if="posts">
        <div v-for="post in posts">
            <template v-if="true">
                <p v-if="auth_user.id !== post.user.id">{{ post.user.username }}</p>
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
                <div :hidden="!comments(post.id)" class="p-2 bg-dark text-light" v-if="comments">
                    <div class="justify-content-center">
                        <a href="#" @click.prevent="drop_comments"><i class="fas fa-xmark"></i></a>
                    </div>
                    <div v-if="postComments" class="" v-for="comment in postComments">
                        <p v-if="comment.is_comment">
                            {{ comment.user.username }}:
                            <strong>
                                {{ comment.content }} | <a @click.prevent="make_answer(comment)" href="#">Ответить</a>
                            </strong><br>
                            {{ comment.created_at }}
                            <a href="#" v-if="comment.user.id === auth_user.id"
                               @click.prevent="deleteComment(comment.id)"><i class="fas fa-trash"></i></a>
                            <div v-if="comment.answers">
                                <p class="p-lg-3" v-for="answer in comment.answers">
                                    {{ answer.user.username }}:
                                    <strong>
                                        {{ answer.content }} | <a
                                        @click.prevent="make_answer({id: comment.id, user: answer.user, content: answer.content})"
                                        href="#">Ответить</a>
                                    </strong><br>
                                    {{ answer.created_at }}
                                    <a href="#" v-if="answer.user.id === auth_user.id"
                                       @click.prevent="deleteComment(answer.id)"><i class="fas fa-trash"></i></a>
                                </p>
                            </div>
                        </p>
                    </div>
                    <div v-if="answer">
                        <a href="#" @click.prevent="dropAnswer"><i class="fas fa-xmark"></i></a>
                        {{ answerToCommentObj.user.username }}:
                        <strong>
                            {{ answerToCommentObj.content }}
                        </strong><br>
                    </div>
                    <div class="d-flex">
                        <input v-model="message_content" type="text" class="form-control w-25">
                        <button @click.prevent="create_comment" class="btn btn-outline-success">Отправить</button>
                    </div>
                </div>
                <hr>
            </template>
        </div>

        <button v-if="!post_end" @click.prevent="load_content" class="btn btn-outline-secondary">Загрузить ещё</button>
    </div>
</template>

<script>

export default {
    name: "IndexComponent",

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
            postComments: [],
            answerToComment: null,
            answerToCommentObj: null
        }
    },

    props: [
        'user',
        'content_per_page',
        'liked_posts',
        'auth_user',
        'user_personal_link',
        'subscribe_on',
    ],

    updated() {
        this.checkContentEnd()
    },

    mounted() {
        this.dataSubscribers = this.subscribers

        this.$store.dispatch('set_postCountMain')


        this.count_content = Number(this.content_per_page)
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get(`/api/show?count_content=${this.count_content}`)
                .then(response => {

                    this.posts = response.data.data
                    this.count_content += Number(this.content_per_page)
                })
        },

        load_content() {

            axios.get(`/api/show?count_content=${this.count_content}`)
                .then(response => {
                    if (response.data.data.length !== 0) {

                        response.data.data.forEach(post => {


                            this.posts.push(post)

                        })
                        this.count_content += Number(this.content_per_page)
                    }

                })
            this.checkContentEnd()
        },

        like(post_id) {

            axios.post(`/api/show/like/${post_id}`)
                .then(response => {
                    axios.get(`/api/show/load_with_limit/${this.auth_user.id}?limit=${this.count_content - 2}&main=true`)
                        .then(response => {
                            this.posts = response.data.data
                        })
                })
        },

        checkContentEnd() {
            if (this.posts.length === Number(this.$store.getters.postCountMain)) {
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

        get_comments() {
            axios.get(`/api/show/comments/${this.post_comment}`)
                .then(response => {
                    console.log(response);
                    this.postComments = response.data.data
                })
        },

        create_comment() {
            axios.post('/api/show/comments', {
                content: this.message_content,
                post_id: this.post_comment,
                comment_id: this.answerToComment
            })
                .then(response => {
                    this.message_content = null
                    this.answerToComment = null
                    this.message_content = null
                    this.answerToCommentObj = null
                    this.get_comments()
                })
        },

        deleteComment(comment_id) {
            if (confirm('Вы уверены, что хотите удалить этот комментарий?'))
                axios.delete(`/api/show/comments/${comment_id}`)
                    .then(response => {
                        this.get_comments()
                    })
        },

        make_answer(comment) {
            this.answerToComment = comment.id
            this.message_content = "@" + comment.user.username + " "
            this.answerToCommentObj = comment
        },

        dropAnswer() {
            this.answerToComment = null
            this.message_content = null
            this.answerToCommentObj = null
        }
    },
    computed: {
        answer() {
            return this.answerToComment
        }
    }
}
</script>

<style scoped>

</style>
