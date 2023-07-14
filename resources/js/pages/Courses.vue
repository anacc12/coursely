<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div
                class="u-display--flex u-display--flex--fill u-display--flex--jc--sb u-mb--sml--4"
            >
                <h1
                    class="u-type u-type--title u-type--title--lrg u-display--flex--fill"
                >
                    Courses
                </h1>
                <router-link
                    v-bind:to="'/new-course'"
                    v-if="$store.state.user.role == 'Admin'"
                >
                    <Button
                        :loading="isLoading"
                        :disabled="isLoading"
                        class="c-btn c-btn--sml c-btn--primary u-display--flex--u"
                    >
                        New course
                    </Button>
                </router-link>
            </div>
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
                        class="c-card c-card--base c-card--primary"
                        data-aos="zoom-out"
                        data-aos-delay="200"
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
                                    <p class="u-type--title--sml">
                                        {{ course.title }}
                                    </p>
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

                        <p class="u-type--base">
                            {{ course.description }}
                        </p>

                        <div
                            class="u-display--flex u-display--flex--gap--sml u-display--full"
                        >
                            <router-link
                                v-bind:to="'/edit-course/' + course.id"
                                class="u-display--full"
                                v-if="$store.state.user.role == 'Admin'"
                            >
                                <Button
                                    :loading="isLoading"
                                    :disabled="isLoading"
                                    class="c-btn c-btn--sml c-btn--outline c-btn--full"
                                >
                                    Edit course
                                </Button>
                            </router-link>
                            <router-link
                                v-bind:to="'/courses/' + course.id"
                                class="u-display--full"
                            >
                                <Button
                                    :loading="isLoading"
                                    :disabled="isLoading"
                                    class="c-btn c-btn--sml c-btn--primary c-btn--full"
                                >
                                    View details
                                </Button>
                            </router-link>
                        </div>
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
            courseProfessor: null,
            professors: [],
            profs: [],
            profName: "",
            show: false,
            subjectsList: [],
            selectedSubject: "",
            activeTab: "All",
        };
    },
    components: {
        Nav,
        Footer,
    },
    methods: {
        isTabActive(subject) {
            return this.activeTab == subject ? "c-tab c-tab--active" : "c-tab";
        },
        getProf(course) {
            this.profs.forEach((prof) => {
                if (prof.id == course.professor_id) {
                    this.profName = prof.firstName + " " + prof.lastName;
                }
            });
        },
        async getCoursesForSubject(subject) {
            const res = await this.callApi(
                "get",
                "/get-courses-for-subject/" + subject.title
            );
            if (res.status === 200) this.courses = res.data;

            this.selectedSubject = subject.title;
            this.activeTab = this.selectedSubject;
        },

        async getAllCourses() {
            this.activeTab = "All";

            const res = await this.callApi("get", "course/get-courses-lessons");
            if (res.status === 200) {
                this.courses = res.data;
            } else {
                console.log(res);
                this.swr();
            }
        },
    },
    async created() {
        this.$store.commit("setCurrentPage", "courses");
        const res = await this.callApi("get", "course/get-courses-lessons");

        console.log(res.data);

        if (res.status === 200) {
            this.courses = res.data;
        } else console.log(res);

        this.courses.forEach((course) => {
            this.professors.push(course.professor_id);
        });
        this.professors.forEach(async (prof_id) => {
            const res6 = await this.callApi("get", "/get-user/" + prof_id);
            this.profs.push(res6.data);
        });
        console.log(this.profs);

        const res7 = await this.callApi("get", "/get-subjects");

        if (res7.status === 200 || res7.status === 201) {
            this.subjectsList = res7.data;
        }
    },
};
</script>

<style lang="scss" scoped></style>
