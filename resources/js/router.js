import Vue from "vue";
import Router from "vue-router";
import store from "./store";

import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";


import NewCourse from "./pages/NewCourse";
import Courses from "./pages/Courses";
import Course from "./pages/Course";
import EditCourse from "./pages/EditCourse";
import UserCourses from "./pages/UserCourses";

import NewLesson from "./pages/NewLesson";
import Lessons from "./pages/Lessons";
import Lesson from "./pages/Lesson";
import EditLesson from "./pages/EditLesson";


import NewQuiz from "./pages/NewQuiz";
import Quiz from "./pages/Quiz";

import UserResults from "./pages/UserResults";

import VueRouter from "vue-router";

Vue.use(Router);

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },

    {
        path: "/login",
        name: "login",
        component: Login,
        beforeEnter: (to, from, next) => {
            if (!store.state.user.status) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        beforeEnter: (to, from, next) => {
            if (!store.state.user.status) {
                next();
            } else {
                next(false);
            }
        },
    },
    
    {
        path: "/new-course",
        name: "new-course",
        component: NewCourse,
        beforeEnter: (to, from, next) => {
            if (store.state.user.status) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: "/courses",
        name: "courses",
        component: Courses,
    },
    {
        path: "/courses/:id",
        name: "courses-id",
        component: Course,
    },
    {
        path: "/edit-course/:id",
        name: "edit-course",
        component: EditCourse,
    },
    {
        path: "/my-courses/:id",
        name: "my-courses",
        component: UserCourses,
        beforeEnter: (to, from, next) => {
            if (store.state.user.status) next();
            else {
                next("/");
            }
        },
        beforeRouteUpdate: (to, from, next) => {
            console.log(this.$route.params);
            if (
                store.state.user.status &&
                this.$route.params == store.state.user.id
            )
                next();
            else {
                next("/");
            }
        },
    },
    
    {
        path: "/new-lesson",
        name: "new-lesson",
        component: NewLesson,
        beforeEnter: (to, from, next) => {
            if (store.state.user.status) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: "/lessons",
        name: "lessons",
        component: Lessons,
    },
    {
        path: "/lessons/:id",
        name: "lessons-id",
        component: Lesson,
    },
    {

        path: "/edit-lesson/:id",
        name: "edit-lesson",
        component: EditLesson,
    },

    {
        path: "/new-quiz",
        name: "new-quiz",
        component: NewQuiz,
    },
    {
        path: "/quiz/:id",
        name: "quiz",
        component: Quiz,
    },
    {
        path: "/user-results/:user_id/:quiz_id",
        name: "user-results",
        component: UserResults,
    },
];

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

export default router;
