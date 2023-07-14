import Vuex from 'vuex'

const store = new Vuex.Store({
    state() {
        return {
            postCount: null,
            postCountMain: null,


            MainPage: '/',
            PersonalPage: '/personal/'
        }
    },

    getters: {

        postCount: (state) => {
            return state.postCount
        },
        postCountMain: (state) => {
            return state.postCountMain
        },


        MainPage: (state) => {
            return state.MainPage
        },

        PersonalPage: (state) => {
            return state.PersonalPage
        }
    },

    mutations: {

        set_postCount: (state, payload) => {
            state.postCount = payload
        },
        set_postCountMain: (state, payload) => {
            state.postCountMain = payload
        },


    },

    actions: {
        set_postCount(state, user_id) {
            axios.get(`/api/get_posts_count/${user_id}`)
                .then(response => {

                    store.commit('set_postCount', response.data.data)

                })
        },
        set_postCountMain(state) {
            axios.get(`/api/get_posts_count_main`)
                .then(response => {

                    store.commit('set_postCountMain', response.data.data)

                })
        },

    }
})

export default store
