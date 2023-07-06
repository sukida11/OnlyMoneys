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
                <a href="" style="pointer-events: none;" class="m-lg-2"><i class="fas fa-heart"></i></a>{{post.likes}}
<!--                <a href="#" class="m-lg-3" @click.prevent="deletePost(post.id)"><i class="far fa-heart"></i></a>-->
            </p>
            <hr>
        </div>
        <button @click.prevent="load_content" class="btn btn-outline-secondary">Загрузить ещё</button>

    </div>
</template>

<script>
export default {
    name: "IndexComponent",

    data() {
        return {
            posts: [],
            count_content: null,
        }
    },

    props: [
        'user',
       'edit_post_route',
        'edit_link_without_id',
        'content_per_page'
    ],

    mounted() {
        this.count_content = Number(this.content_per_page)
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get(`/api/posts?count_content=${this.count_content}`)
                .then(response => {
                    console.log(response);
                    this.posts = response.data.data
                    this.count_content += Number(this.content_per_page)
                })
        },

        deletePost(id) {
            if (confirm('Вы правда хотите удалить этот пост?')) {
                axios.delete(`/api/posts/${id}`)
                    .then(response => {
                        this.getPosts()
                    })
            }
        },

        load_content() {

            axios.get(`/api/posts?count_content=${this.count_content}`)
                .then(response => {
                    response.data.data.forEach(post => {
                        this.posts.push(post)
                    })
                    this.count_content += Number(this.content_per_page)
                })

        }
    }
}
</script>

<style scoped>

</style>
