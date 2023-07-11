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
                <a href="" style="pointer-events: none;" class="m-lg-2"><i class="fas fa-heart"></i></a>{{ post.likes }}
                <!--                <a href="#" class="m-lg-3" @click.prevent="deletePost(post.id)"><i class="far fa-heart"></i></a>-->
            </p>
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
            post_end: false
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
        }
    }
}
</script>

<style scoped>

</style>
