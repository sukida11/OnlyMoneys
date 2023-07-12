<template>
    <div v-if="posts">
        <div v-for="post in posts">
            <p v-if="user.id !== post.user.id">{{ post.user.username }}</p>
            <h5>{{ post.content }}</h5>
            <div class="d-flex mt-2 mb-2" style="width: 100px ; height: 100px">
                <img v-for="image in post.images" :src="image.url" alt="">
            </div>
            <p>
                {{ post.created_at }}
            </p>
            <p v-if="user.id === post.user.id">
                <a class="btn btn-outline-primary" :href="`${this.edit_link_without_id}${post.id}`">Редактировать</a>
                <a href="#" class="m-lg-3" @click.prevent="deletePost(post.id)"><i class="fas fa-trash"></i></a>
                <a href="" style="pointer-events: none;" class="m-lg-2"><i class="fas fa-heart"></i></a>{{ post.likes }}&nbsp;
                <a href="#" @click.prevent="check_comments(post.id)"><i class="fas fa-message"></i></a>
            </p>
            <div :hidden="!comments(post.id)" class="p-2 bg-dark text-light" v-if="comments">
                <div class="justify-content-center">
                    <a href="#" @click.prevent="drop_comments"><i class="fas fa-xmark"></i></a>
                </div>
                <div v-if="postComments" class="" v-for="comment in postComments">
                    <p v-if="comment.is_comment">
                        {{  comment.user.username }}:
                        <strong>
                            {{comment.content}} | <a @click.prevent="make_answer(comment)" href="#">Ответить</a>
                        </strong><br>
                        {{ comment.created_at }}
                        <a href="#" @click.prevent="deleteComment(comment.id)"><i class="fas fa-trash"></i></a>
                        <div v-if="comment.answers">
                            <p class="p-lg-3" v-for="answer in comment.answers">
                                {{  answer.user.username }}:
                                <strong>
                                    {{answer.content}} | <a @click.prevent="make_answer({id: comment.id, username: answer.user.username, content: answer.content})" href="#">Ответить</a>
                                </strong><br>
                                {{ answer.created_at }}
                                <a href="#" @click.prevent="deleteComment(answer.id)"><i class="fas fa-trash"></i></a>
                            </p>
                        </div>
                    </p>
                </div>
                <div v-if="answer">
                    <a href="#" @click.prevent="dropAnswer"><i class="fas fa-xmark"></i></a>
                    {{  answerToCommentObj.user.username }}:
                    <strong>
                        {{answerToCommentObj.content}}
                    </strong><br>
                </div>
                <div class="d-flex">
                    <input v-model="message_content" type="text" class="form-control w-25">
                    <button @click.prevent="create_comment" class="btn btn-outline-success">Отправить</button>
                </div>
            </div>
            <hr>
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
            post_comment: null,
            message_content: null,
            postComments: [],
            answerToComment: null,
            answerToCommentObj: null
        }
    },

    props: [
        'user',
        'edit_post_route',
        'edit_link_without_id',
        'content_per_page',
        'post_count'
    ],

    updated() {
        this.checkContentEnd()
    },

    mounted() {
        this.count_content = Number(this.content_per_page)
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get(`/api/posts?count_content=${this.count_content}`)
                .then(response => {
                    this.posts = response.data.data
                    this.count_content += Number(this.content_per_page)
                })
        },

        deletePost(id) {
            if (confirm('Вы правда хотите удалить этот пост?')) {
                axios.delete(`/api/posts/${id}`)
                    .then(response => {
                        axios.get(`/api/show/load_with_limit/${this.posts[0].user.id}?limit=${this.count_content-2}`)
                            .then(response => {
                                this.posts = response.data.data
                            })
                    })
            }
            this.checkContentEnd()
        },

        load_content() {

            axios.get(`/api/posts?count_content=${this.count_content}`)
                .then(response => {


                    if (response.data.data.length !== 0) {

                        response.data.data.forEach(post => {
                            console.log(post);


                            this.posts.push(post)

                        })
                        this.count_content += Number(this.content_per_page)
                    }

                })

        },

        checkContentEnd()
        {
            if(this.posts.length === Number(this.post_count))
            {
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

        deleteComment(comment_id)
        {
            if(confirm('Вы уверены, что хотите удалить этот комментарий?'))
                axios.delete(`/api/show/comments/${comment_id}`)
                    .then(response => {
                        this.get_comments()
                    })
        },

        make_answer(comment)
        {
            this.answerToComment = comment.id
            this.message_content ="@" + comment.user.username + " "
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
