<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div
                class="u-display--flex u-display--flex--gap--base u-mb--sml--4"
            >
                <img :src="`${course.image}`" alt class="c-img--base" />
                <div
                    class="title u-display--flex u-display--flex--jc--sb u-display--flex--fill u-display--flex--ai--start"
                >
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--fill"
                    >
                        <h1 class="u-type u-type--title u-type--title--lrg">
                            {{ course.title }}
                        </h1>
                        <div class="c-breadcrumbs__container">
                            <router-link
                                to="/courses"
                                v-if="$store.state.currentPage != 'my-courses'"
                            >
                                <Button class="c-btn--anchor">
                                    Courses
                                </Button></router-link
                            >
                            <router-link
                                v-bind:to="
                                    '/my-courses/' + $store.state.user.id
                                "
                                v-else
                            >
                                <Button class="c-btn--anchor">
                                    My Courses
                                </Button>
                            </router-link>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="10"
                                height="10"
                                fill="none"
                            >
                                <path
                                    stroke="#5E5E5E"
                                    stroke-width="1.3"
                                    d="M3.542 9.375 7.917 5 3.542.625"
                                />
                            </svg>

                            <Button class="c-btn--anchor c-btn--anchor--active">
                                {{ course.title }}
                            </Button>
                        </div>
                        <!-- v-show="isUserCourse" -->
                    </div>
                    <div class="u-display--flex u-display--flex--gap--sml">
                        <Button
                            v-if="
                                $store.state.user.status &&
                                !isUserCourse &&
                                !isProfessorCourse &&
                                $store.state.user.role != 'Admin'
                            "
                            class="c-btn c-btn--sml c-btn--primary"
                            :loading="isCreating"
                            :disabled="isCreating"
                            @click="enrollUserInCourse"
                        >
                            Enroll now
                        </Button>

                        <Button
                            v-if="$store.state.user.status && isUserCourse"
                            v-bind:class="checkIsUserCourse()"
                            :loading="isCreating"
                            :disabled="
                                !this.isUserCourse ||
                                this.isQuizTaken ||
                                !this.hasQuiz
                            "
                            @click="takeTheQuiz"
                        >
                            Take the quiz
                        </Button>

                        <router-link
                            v-if="
                                isProfessorCourse ||
                                $store.state.user.role == 'Admin'
                            "
                            v-bind:to="'/edit-course/' + this.id"
                        >
                            <Button class="c-btn c-btn--sml c-btn--outline"
                                >Edit course</Button
                            >
                        </router-link>

                        <router-link
                            v-if="
                                (isProfessorCourse ||
                                    $store.state.user.role == 'Admin') &&
                                !hasQuiz
                            "
                            v-bind:to="'/new-quiz'"
                        >
                            <Button
                                class="c-btn c-btn--sml c-btn--primary"
                                :loading="isCreating"
                                :disabled="isCreating"
                            >
                                Create quiz
                            </Button>
                        </router-link>
                    </div>
                </div>
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
                <div class="c-container--split c-container--split--3">
                    <div class="c-container--aside">
                        <div class="u-display--flex u-display--flex--col">
                            <div @click="showOverview()">
                                <p
                                    class="u-type--base cursor--p"
                                    :class="{
                                        'u-type--accent':
                                            selectedTopic == 'Overview',
                                    }"
                                >
                                    Overview
                                </p>
                            </div>

                            <div v-for="(lesson, i) in course.lessons" :key="i">
                                <div @click="showLessonContent(lesson.id)">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="100%"
                                        height="1"
                                        fill="none"
                                    >
                                        <path stroke="#F1EFFB" d="M0 .5h1333" />
                                    </svg>
                                    <p
                                        class="u-type--base cursor--p"
                                        :class="{
                                            'u-type--accent':
                                                selectedTopic == lesson.title,
                                        }"
                                    >
                                        {{ lesson.title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div
                                class="u-display--flex u-display--flex--fill u-display--flex--jc--sb u-display--flex--ai--center u-mb--sml--4"
                            >
                                <h1
                                    class="u-type u-type--title u-type--title--base u-display--flex--fill"
                                >
                                    {{ selectedTopic }}
                                </h1>

                                <div
                                    class="u-display--flex u-display--flex--gap--sml"
                                >
                                    <Button
                                        class="c-btn c-btn--sml c-btn--outline"
                                        :loading="isCreating"
                                        :disabled="isCreating"
                                        v-if="selectedLesson.pdf != null"
                                        @click="downloadPdf(selectedLesson.pdf)"
                                    >
                                        Download pdf
                                    </Button>
                                    <router-link
                                        v-if="
                                            ($store.state.user.role ==
                                                'Admin' ||
                                                isProfessorCourse) &&
                                            selectedTopic != 'Overview'
                                        "
                                        v-bind:to="
                                            '/edit-lesson/' + selectedLesson.id
                                        "
                                    >
                                        <Button
                                            class="c-btn c-btn--sml c-btn--outline"
                                            >Edit lesson</Button
                                        >
                                    </router-link>
                                    <router-link
                                        v-if="
                                            $store.state.user.role == 'Admin' ||
                                            isProfessorCourse
                                        "
                                        v-bind:to="'/new-lesson'"
                                    >
                                        <Button
                                            class="c-btn c-btn--sml c-btn--primary"
                                            @click="setCourseId()"
                                            >New lesson</Button
                                        >
                                    </router-link>
                                </div>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--4"
                            >
                                <path stroke="#F8F7FD" d="M0 .5h1333" />
                            </svg>
                        </div>
                        <div
                            v-show="lessonContent"
                            class="u-display--flex u-display--flex--col"
                        >
                            {{ selectedLesson.description }}
                        </div>
                        <div v-if="selectedTopic == 'Overview'">
                            <div class="u-mb--sml--4">
                                <p
                                    class="u-type--title u-type--title--sml u-mb--sml--1"
                                >
                                    Course Description
                                </p>
                                <p class="u-type--base">
                                    {{ course.description }}
                                </p>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--4"
                            >
                                <path stroke="#F8F7FD" d="M0 .5h1333" />
                            </svg>

                            <div class="u-mb--sml--4">
                                <p
                                    class="u-type--title u-type--title--sml u-mb--sml--1"
                                >
                                    Subject
                                </p>
                                <p class="u-type--base">
                                    {{ course.subject }}
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--4"
                            >
                                <path stroke="#F8F7FD" d="M0 .5h1333" />
                            </svg>

                            <div class="u-mb--sml--4">
                                <p
                                    class="u-type--title u-type--title--sml u-mb--sml--1"
                                >
                                    Lessons included
                                </p>
                                <p class="u-type--base">
                                    {{ course.lessons.length }}
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--4"
                            >
                                <path stroke="#F8F7FD" d="M0 .5h1333" />
                            </svg>

                            <div class="u-mb--sml--4">
                                <p
                                    class="u-type--title u-type--title--sml u-mb--sml--1"
                                >
                                    Difficulty
                                </p>
                                <p class="u-type--base">
                                    {{ course.difficulty }}
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--4"
                            >
                                <path stroke="#F8F7FD" d="M0 .5h1333" />
                            </svg>

                            <div class="buttons">
                                <!-- ovak profesor može editat -->
                            </div>
                        </div>
                    </div>

                    <div
                        class="c-container--aside c-container--aside--secondary"
                    >
                        <div
                            class="u-display--flex u-display--flex--col u-display--flex--gap--xsml u-display--full"
                        >
                            <p class="u-type--title u-type--title--xsml">
                                Enrolled at
                            </p>
                            <p class="u-type--sml">12.06.2023.</p>
                        </div>
                        <div
                            class="u-display--flex u-display--flex--col u-display--flex--gap--xsml u-display--full"
                        >
                            <p class="u-type--title u-type--title--xsml">
                                Final results
                            </p>
                            <p
                                v-if="!isQuizTaken || !isUserCourse"
                                class="u-type--sml"
                            >
                                No results yet
                            </p>
                            <router-link
                                v-if="isQuizTaken && isUserCourse"
                                v-bind:to="
                                    '/user-results/' + user_id + '/' + quiz_id
                                "
                            >
                                <Button
                                    v-if="$store.state.user.status"
                                    :loading="isCreating"
                                    :disabled="isCreating"
                                    class="c-btn c-btn--sml c-btn--primary"
                                >
                                    Get results
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
import avatar from "../assets/avatar.png";

export default {
    data() {
        return {
            id: this.$route.params.id,
            isUserCourse: false,
            isProfessorCourse: false,
            user_id: this.$store.state.user.id,
            course: [],
            courseUsers: [],
            lessonContent: false,
            avatar: avatar,
            hasQuiz: false,
            selectedLesson: {
                title: "",
                description: "",
            },
            isQuizTaken: false,
            isCreating: false,
            isEditing: false,
            userCourseData: {
                user_id: this.$store.state.user.id,
                course_id: null,
            },
            quiz_id: null,
            selectedTopic: "Overview",
            currentLesson: null,
        };
    },

    components: {
        Nav,
    },

    methods: {
        downloadPdf(lessonPdf) {
            axios({
                url: "http://localhost:8000" + lessonPdf,
                method: "GET",
                responseType: "blob",
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                var fileLink = document.createElement("a");

                fileLink.href = fileURL;
                fileLink.setAttribute("download", "lesson-pdf.pdf");
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
        setCourseId() {
            this.$store.commit("setCourseId", this.course.id);
        },
        takeTheQuiz() {
            this.$router.push({ path: "/quiz/" + this.course.id });
        },
        checkIsUserCourse() {
            return this.isUserCourse && !this.isQuizTaken && this.hasQuiz
                ? "c-btn c-btn--sml c-btn--primary"
                : "c-btn c-btn--sml c-btn--disabled";
        },
        checkUserCourse(users) {
            users.forEach((user) => {
                if (user.id == this.user_id) this.isUserCourse = true;
                else this.isUserCourse = false;
            });
        },
        showOverview() {
            this.selectedTopic = "Overview";
            this.lessonContent = false;
        },
        showLessonContent(lesson_id) {
            this.lessonContent = true;

            this.course.lessons.forEach((lesson) => {
                if (lesson.id == lesson_id) {
                    this.selectedLesson.id = lesson.id;
                    this.selectedLesson.title = lesson.title;
                    this.selectedLesson.user_id = lesson.user_id;
                    this.selectedLesson.description = lesson.description;
                    this.selectedLesson.pdf = lesson.pdf;
                }
            });

            this.selectedTopic = this.selectedLesson.title;
        },
        async enrollUserInCourse() {
            this.isCreating = true;
            this.userCourseData.course_id = this.course.id;

            console.log(this.userCourseData);
            const res = await this.callApi(
                "post",
                "/enroll-user",
                this.userCourseData
            );

            if (res.status === 200 || res.status === 201) {
                this.success("Enrolled successfully!");
                this.$router.push({
                    path: "/my-courses/" + this.userCourseData.course_id,
                });
            } else {
                console.log(res);
                this.swr();
            }
            this.isCreating = false;
        },
    },
    async created() {
        const res2 = await this.callApi(
            "get",
            "/get-course-with-lessons/" + this.id
        );
        if (res2.status === 200) {
            this.course = res2.data[0];
            console.log(res2.data[0]);
        } else console.log(res2);

        if (this.$store.state.user.id == this.course.professor_id) {
            this.isProfessorCourse = true;
        } else this.isProfessorCourse = false;

        const res = await this.callApi("get", "/get-course-users/" + this.id);
        if (res.status === 200) {
            this.courseUsers = res.data;
            this.checkUserCourse(this.courseUsers);
        }

        const res3 = await this.callApi("get", "/check-course-quiz/" + this.id);
        if (res3.status === 200 || res3.status === 201) {
            this.hasQuiz = res3.data;
        } else {
            console.log(res3);
            this.swr();
        }

        console.log("isUserCourse:" + this.isUserCourse);
        console.log("professor_id:" + this.course.professor_id);
        console.log("current user id:" + this.$store.state.user.id);
        console.log("isProfessorCourse: " + this.isProfessorCourse);

        const res4 = await this.callApi(
            "get",
            "/check-user-course-quiz/" + this.user_id + "/" + this.id
        );

        if (res4.status === 200 || res4.status === 201) {
            if (res4.data != 1) this.isQuizTaken = false;
            else this.isQuizTaken = true;
        } else {
            console.log(res4);
            this.swr();
        }

        if (this.isUserCourse) {
            const res5 = await this.callApi(
                "get",
                "/get-user-course-quiz/" + this.user_id + "/" + this.id
            );
            if (res5.status === 200 || res5.status === 201) {
                this.quiz_id = res5.data.user_quizzes[0].id;
            } else {
                console.log(res5);
                this.swr();
            }
        }

        if (this.isUserCourse || this.isProfessorCourse)
            this.$store.commit("setCurrentPage", "my-courses");
        else this.$store.commit("setCurrentPage", "courses");
    },
};
</script>

<style lang="scss" scoped></style>
