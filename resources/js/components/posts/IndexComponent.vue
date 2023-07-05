<template>
    <div v-if="posts">
        <div v-for="post in posts">
            <p v-if="user.id !== post.user.id">{{ post.user.username}}</p>
            <h5>{{post.content}}</h5>
            <div class="d-flex mt-2 mb-2" style="width: 100px ; height: 100px">
                <img v-for="image in post.images"  :src="image.url" alt="">
            </div>
            <p>
                {{ post.created_at }}
            </p>
            <p v-if="user.id === post.user.id">
                <a class="btn btn-outline-primary" :href="`${this.edit_link_without_id}${post.id}`">Редактировать</a>
                <a href="#" class="m-lg-3" @click.prevent="deletePost(post.id)"><i class="fas fa-trash"></i></a>
            </p>
            <hr>
        </div>

    </div>
</template>

<script>
export default {
    name: "IndexComponent",

    data() {
        return {
            posts: null,
        }
    },

    props: [
        'user',
       'edit_post_route',
        'edit_link_without_id'
    ],

    mounted() {
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get('/api/posts')
                .then(response => {
                    this.posts = response.data.data
                })
        },

        deletePost(id) {
            if (confirm('Вы правда хотите удалить этот пост?')) {
                axios.delete(`/api/posts/${id}`)
                    .then(response => {
                        this.getPosts()
                    })
            }
        }
    }
}
</script>

<style scoped>

</style>
