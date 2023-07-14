<template>
    <h1>Создание публикации</h1>
    <div class="form-group">
        <p>
            <textarea name="content" id="content" cols="" class="form-control" placeholder="content" v-model="content" rows="10"></textarea>
        </p>
    </div>
    <div ref="dropzone" class="btn bg-dark text-light d-flex" style="height: 300px">
        Фотографии для поста
    </div>
    <p class="mt-4">
        <select v-model="paidOrFree" name="post_status">
            <template v-for="(value, key) in paidOrFreeJSON" >
                <option v-if="key === 0" selected :value="key">{{value}}</option>
                <option v-if="key !== 0"  :value="key">{{value}}</option>
            </template>
        </select>
    </p>
    <p class="mt-4">
        <input @click.prevent="store" type="submit" class="btn btn-outline-primary" value="Создать">
    </p>
</template>

<script>
import Dropzone from 'dropzone'

export default {
    name: "ImagesComponent",

    data() {
        return {
            dropzone: null,
            content: null,
            paidOrFreeJSON: null,
            paidOrFree: null
        }
    },

    mounted() {
        this.getPostStatus()
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true
        })
    },

    methods: {
        store() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                data.append('images[]', file)
            })
            data.append('content', this.content)
            data.append('paid', this.paidOrFree);
            this.dropzone.removeAllFiles()
            this.content = null
            axios.post(`/api/posts`, data)
                .then(response => {
                    console.log(response);
                    window.location.replace(this.$store.getters.PersonalPage)
                })
        },

        getPostStatus() {
            axios.get('/api/paid')
                .then(response => {
                    this.paidOrFreeJSON = response.data
                    this.paidOrFree = Object.keys(this.paidOrFreeJSON)[0];
                })
        }

    }

}
</script>

<style >
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
