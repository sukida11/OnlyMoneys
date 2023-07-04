<template>
    <h1>Редактирование публикации</h1>
    <div class="form-group" v-if="post">
        <p>
            <textarea name="content" id="content" cols="" class="form-control" placeholder="content" v-model="post.content" rows="10"></textarea>
        </p>
    </div>
    <div ref="dropzone" class="btn bg-dark text-light d-flex" style="height: 300px">
        Фотографии для поста
    </div>
    <p class="mt-4">
        <input @click.prevent="update" type="submit" class="btn btn-outline-primary" value="Создать">
    </p>
</template>

<script>
import Dropzone from "dropzone";

export default {
    name: "UpdateComponent",

    data() {
        return {
            dropzone: null,
            post: null,
            imagesIdForDelete: []
        }
    },

    props: [
        'post_id'
    ],

    mounted() {
        this.getPost()
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true
        })
        this.dropzone.on('removedfile', (file) => {
            this.imagesIdForDelete.push(file.id)
        })
    },

    methods: {
        update() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                data.append('images[]', file)
            })
            data.append('content', this.post.content)
            this.imagesIdForDelete.forEach(id => {
                data.append('delete_images[]', id)
            })
            data.append('_method', 'patch')
            this.dropzone.removeAllFiles()
            this.content = null
            axios.post(`/api/posts/${this.post_id}`, data)
                .then(response => {
                    window.location.replace(response.data.redirect_to)
                })
        },

        getPost() {
            axios.get(`/api/posts/${this.post_id}`)
                .then(response => {
                    console.log(response);
                    this.post = response.data.data;
                    this.post.images.forEach(image => {
                        let file = {id: image.id, name: image.name, size: image.size}
                        this.dropzone.displayExistingFile(file, image.url);
                    })
                })
        }
    }

}
</script>

<style scoped>
.drag{
    border-radius: 14px;
}
.dz-details,
.dz-size,
.dz-filename,
.dz-error-message,
.dz-success-mark,
.dz-error-mark {
    display: none;
}
</style>
