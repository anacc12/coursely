import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: {
            status: false,
            username: "",
            role: "",
            id: "",
        },
        userCourse: {
            user_id: "",
        },
        currentPage: "",
        course_id: null,
    },
    getters:{},
    actions: {},
    mutations: {
        setUserLoginStatus(state, data) {
            state.user.status = data;
            if (data.firstName) {
                state.user.username = data.firstName;
                state.user.role = data.role;
                state.user.id = data.id;
            }
        },
        
        setUserCourse(state, data) {
            state.userCourse.user_id = data;
        }, 

        setCurrentPage(state,data) {
            state.currentPage = data;
        },

        setCourseId(state, data) {
            state.course_id = data;
        }, 
    },

});

export default store;