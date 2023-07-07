<template>
    <div :key="renderKey" class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <h1 class="u-type u-type--title u-type--title--lrg u-mb--sml--4">
                My Courses
            </h1>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="100%"
                height="1"
                fill="none"
                class="u-mb--sml--4"
            >
                <path stroke="#F1EFFB" d="M0 .5h1333" />
            </svg>
            <b-container class="c-container--content">
                <div class="c-tab__container u-mb--sml--5">
                    <div
                        @click="getAllCourses()"
                        v-bind:class="isTabActive('All')"
                    >
                        <p>All</p>
                    </div>
                    <div
                        class="c-tab"
                        v-for="(subject, i) in subjectsList"
                        :key="i"
                        @click="getCoursesForSubject(subject)"
                        v-bind:class="isTabActive(subject.title)"
                    >
                        <p>{{ subject.title }}</p>
                    </div>
                </div>
                <h1
                    class="u-type u-type--title u-type--title--base u-mb--sml--4"
                >
                    {{ activeTab }} courses
                </h1>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="100%"
                    height="1"
                    fill="none"
                    class="u-mb--sml--4"
                >
                    <path stroke="#F8F7FD" d="M0 .5h1333" />
                </svg>
                <div class="c-container--cards">
                    <div
                        v-for="(course, i) in courses"
                        :key="i"
                        cols="4"
                        data-aos="zoom-out"
                        class="c-card c-card--base c-card--primary"
                    >
                        <div
                            class="u-display--flex u-display--flex--jc--sb u-display--full"
                        >
                            <div
                                class="u-display--flex u-display--flex--gap--sml"
                            >
                                <img :src="`${course.image}`" alt />
                                <div
                                    class="u-display--flex u-display--flex--col"
                                >
                                    <h2 class="u-type--title--sml">
                                        {{ course.title }}
                                    </h2>
                                    <p class="u-type--sml">
                                        <span v-show="show">{{
                                            getProf(course)
                                        }}</span>
                                        {{ profName }}
                                        <!-- {{ courseProfessor }} -->
                                    </p>
                                </div>
                            </div>
                            <div class="c-card__tag">
                                {{ course.difficulty }}
                            </div>
                        </div>

                        <div class="info-box">
                            <p class="u-type--base">
                                {{ course.description }}
                            </p>
                        </div>
                        <router-link
                            v-bind:to="'/courses/' + course.id"
                            class="u-display--full"
                        >
                            <Button
                                :loading="isLoading"
                                :disabled="isLoading"
                                class="c-btn c-btn--sml c-btn--primary c-btn--full"
                            >
                                View course
                            </Button>
                        </router-link>
                    </div>
                </div>
            </b-container>
        </b-container>
    </div>
</template>

<script>
import Nav from "../components/Nav";
import Footer from "../components/Footer";

export default {
    data() {
        return {
            courses: [],
            isLoading: false,
            id: "",
            show: false,
            renderKey: 0,
            user_id: this.$store.state.user.id,
            courseProfessor: null,
            professors: [],
            profs: [],
            profName: "",
            subjectsList: [],
            coursesForSubject: [],
            selectedSubject: "",
            activeTab: "All",
        };
    },
    components: {
        Nav,
        Footer,
    },
    computed: {},
    methods: {
        isTabActive(subject) {
            return this.activeTab == subject ? "c-tab c-tab--active" : "c-tab";
        },
        getProf(course) {
            this.profs.forEach((prof) => {
                if (prof.id == course.professor_id) {
                    this.profName = prof.firstName + "" + prof.lastName;
                }
            });
        },
        async getAllCourses() {
            this.activeTab = "All";

            const res = await this.callApi(
                "get",
                "/get-user-courses/" + this.id
            );
            if (res.status === 200) {
                this.courses = res.data;
            } else {
                console.log(res);
                this.swr();
            }
        },
        async getCoursesForSubject(subject) {
            if (this.$store.state.user.role == "Professor") {
                const res = await this.callApi(
                    "get",
                    "/get-professor-courses-for-subject/" +
                        this.id +
                        "/" +
                        subject.title
                );
                if (res.status === 200) this.courses = res.data;

                this.selectedSubject = subject.title;
                this.activeTab = this.selectedSubject;
            } else {
                const res = await this.callApi(
                    "get",
                    "/get-user-courses-for-subject/" +
                        this.id +
                        "/" +
                        subject.title
                );
                if (res.status === 200) this.courses = res.data;

                this.selectedSubject = subject.title;
                this.activeTab = this.selectedSubject;
            }
        },
    },
    async created() {
        this.$store.commit("setCurrentPage", "my-courses");
        this.id = this.$store.state.user.id;
        console.log(this.id);

        if (this.$store.state.user.role == "Professor") {
            const res = await this.callApi(
                "get",
                "/get-professor-courses/" + this.id
            );
            if (res.status === 200) {
                this.courses = res.data;
            } else {
                console.log(res);
                this.swr();
            }
        } else {
            const res = await this.callApi(
                "get",
                "/get-user-courses/" + this.id
            );
            if (res.status === 200) {
                this.courses = res.data;
            } else {
                console.log(res);
                this.swr();
            }
        }
        const res2 = await this.callApi(
            "get",
            "/count-user-courses/" + this.id
        );

        this.courses.forEach((course) => {
            this.professors.push(course.professor_id);
        });

        this.professors.forEach(async (prof_id) => {
            const res6 = await this.callApi("get", "/get-user/" + prof_id);
            this.profs.push(res6.data);
        });

        const res7 = await this.callApi("get", "/get-subjects");

        if (res7.status === 200 || res7.status === 201) {
            this.subjectsList = res7.data;
        }
    },
};
</script>

<style lang="scss" scoped></style>
