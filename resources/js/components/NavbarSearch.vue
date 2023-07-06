<template>
    <div>
        <ul class="nav navbar-nav pull-xs-right">
            <li class="nav-item">
                <div class="d-flex">
                    <input class="form-control" v-model="usernameForSearch" type="text" placeholder="Search">
                    <button class="btn btn-outline-success" @click.prevent="findPerson" type="submit">Search</button>
                </div>
            </li>
            <div class="dropdown-menu d-inline-block" v-if="search" style="margin-top:2.5em">
                <div v-if=" typeof searchResult === 'string' ">
                    <li><a class="dropdown-item" href="#">{{ searchResult }}</a></li>
                </div>
                <div v-else-if=" typeof searchResult === 'object' ">
                    <li v-for="user in searchResult"><a class="dropdown-item" :href="this.link_to_user_page+user.id">{{ user.username }}</a></li>
                </div>
                <li><a @click.prevent="closeSearch" class="dropdown-item text-center" href="#"><i class="fas fa-xmark"></i></a></li>
            </div>
        </ul>
    </div>
</template>

<script>
export default {
    name: "NavbarSearch",
    data() {
        return {
            searchResult: null,
            usernameForSearch: null
        }
    },

    props: [
        'link_to_user_page'
    ],

    methods: {
        findPerson() {
            axios.get(`/api/personal/find?username=${this.usernameForSearch}`)
                .then(response => {
                    console.log(response);
                    if (response.data.message)
                    {
                        this.searchResult = response.data.message
                    }
                    else
                    {
                        this.searchResult = response.data.data
                    }
                })
        },

        closeSearch() {
            this.searchResult = null
        }
    },

    computed: {
        search() {
            return this.searchResult
        }
    }
}
</script>

<style scoped>

</style>
