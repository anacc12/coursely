<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div class="u-display--flex u-display--flex--col u-mb--sml--4">
                <h1 class="u-type u-type--title u-type--title--lrg">
                    Create a quiz
                </h1>
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
                <div
                    class="u-display--flex u-display--flex--col u-display--flex--gap--med u-display--width--60"
                >
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="title"
                            >Quiz title</label
                        >
                        <b-form-input
                            v-model="quizData.title"
                            type="text"
                        ></b-form-input>
                    </div>
                    <div
                        class="u-display--flex u-display--flex--ai--center u-display--flex--fill u-display--flex--jc--sb"
                    >
                        <p class="u-type--title u-type--title--sml">Question</p>
                        <Button
                            class="c-btn c-btn--primary c-btn--sml u-display--flex--u"
                            @click="addQuestion()"
                            >Add</Button
                        >
                    </div>
                    <div
                        v-for="(item, index) in allQuestions"
                        v-bind:item="item"
                        v-bind:index="index"
                        v-bind:key="item.id"
                        class="c-card c-card--tertiary"
                    >
                        <div
                            class="u-display--flex u-display--full u-display--flex--gap--xsml u-display--jc--sb u-display--flex--ai--end"
                        >
                            <div
                                class="u-display--flex u-display--flex--col u-display--flex--gap--xsml u-display--full"
                            >
                                <label class="c-input__label"
                                    >Question Text</label
                                >
                                <b-form-input
                                    v-model="item.text"
                                ></b-form-input>
                            </div>
                            <Button
                                v-if="index > 0"
                                class="c-btn c-btn--outline c-btn--sml height--ft"
                                @click="removeQuestion(index)"
                                >Remove</Button
                            >
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="100%"
                            height="1"
                            fill="none"
                            class="u-mb--sml--2"
                        >
                            <path stroke="#F1EFFB" d="M0 .5h1333" />
                        </svg>
                        <div
                            class="u-display--flex u-display--flex--ai--center u-display--flex--fill u-display--full u-display--flex--jc--sb"
                        >
                            <p class="u-type--title u-type--title--xsml">
                                Options
                            </p>
                            <Button
                                class="c-btn c-btn--outline c-btn--sml u-display--flex--u"
                                @click="addOption(index)"
                                >Add option</Button
                            >
                        </div>
                        <div
                            v-for="(it, idx) in allOptions"
                            v-bind:item="it"
                            v-bind:index="idx"
                            v-bind:key="it.id"
                            v-show="it.quest_id == index"
                            class="u-display--full"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="1"
                                fill="none"
                                class="u-mb--sml--2"
                            >
                                <path stroke="#F1EFFB" d="M0 .5h1333" />
                            </svg>
                            <div
                                class="u-mb--sml--2 u-display--flex u-display--flex--col u-display--flex--gap--xsml u-display--full"
                            >
                                <label class="c-input__label">
                                    Option Text
                                </label>
                                <b-form-input v-model="it.text"></b-form-input>
                            </div>

                            <div
                                class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                            >
                                <label class="c-input__label"
                                    >Option Points</label
                                >
                                <b-form-input
                                    v-model="it.points"
                                    type="number"
                                ></b-form-input>
                            </div>

                            <Button
                                v-if="idx > 0"
                                class="c-btn c-btn--outline c-btn--sml u-mt--sml--2 u-display--full"
                                @click="removeOption(idx)"
                                >Remove option</Button
                            >
                        </div>
                    </div>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="100%"
                        height="1"
                        fill="none"
                    >
                        <path stroke="#F8F7FD" d="M0 .5h1333" />
                    </svg>
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label">Passing points</label>
                        <b-form-input
                            v-model="quizData.passing_points"
                            class="Quiz"
                            type="number"
                        ></b-form-input>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label for="course" class="c-input__label"
                            >Select course</label
                        >
                        <b-select
                            class="form-control"
                            v-model="selectedCourse"
                            v-if="$store.state.user.role == 'Professor'"
                        >
                            <option :value="''" disabled selected>
                                Select a course
                            </option>
                            <option
                                v-for="course in professorCoursesList"
                                :key="course.id"
                                :value="course"
                            >
                                {{ course.title }}
                            </option>
                        </b-select>

                        <b-select
                            class="form-control"
                            v-model="selectedCourse"
                            v-if="$store.state.user.role == 'Admin'"
                        >
                            <option :value="''" disabled selected>
                                Select a course
                            </option>
                            <option
                                v-for="course in coursesList"
                                :key="course.id"
                                :value="course"
                            >
                                {{ course.title }}
                            </option>
                        </b-select>
                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="100%"
                        height="1"
                        fill="none"
                    >
                        <path stroke="#F8F7FD" d="M0 .5h1333" />
                    </svg>
                    <div
                        class="u-display--flex u-display--flex--jc--sb u-display--flex--fill"
                    >
                        <router-link to="/">
                            <Button class="c-btn c-btn--base c-btn--outline"
                                >Cancel</Button
                            >
                        </router-link>
                        <Button
                            @click="validateQuiz"
                            class="c-btn c-btn--base c-btn--primary u-display--flex--u"
                            :loading="isCreating"
                            :disabled="isCreating"
                        >
                            Save
                        </Button>
                    </div>
                </div>
            </b-container>
        </b-container>
    </div>
</template>

<script>
import Nav from "../components/Nav";
export default {
    data() {
        return {
            user_id: this.$store.state.user.id,
            quizData: {
                title: "",
                course_id: "",
                passing_points: null,
            },
            questionsData: {
                questions: [],
                options: [],
                quiz_id: null,
            },
            allQuestions: [
                {
                    text: "",
                },
            ],
            allOptions: [],
            isCreating: false,
            token: "",
            coursesList: [],
            professorCoursesList: [],
            selectedCourse: {},
        };
    },

    methods: {
        removeQuestion(index) {
            this.allQuestions.splice(index, 1);
        },

        addQuestion() {
            let questions = [
                {
                    text: "",
                },
            ];
            this.allQuestions.push(...questions);
        },

        removeOption(idx) {
            this.allOptions.splice(idx, 1);
        },

        addOption(index) {
            let options = [
                {
                    text: "",
                    points: "",
                    quest_id: index,
                },
            ];
            this.allOptions.push(...options);
        },

        validateQuiz() {
            console.log("Test questions: " + this.allQuestions);

            this.questionsData.questions = this.allQuestions;
            this.questionsData.options = this.allOptions;

            console.log(this.questionsData);
            this.saveQuiz();
        },

        async saveQuiz() {
            this.isCreating = true;
            this.quizData.course_id = this.selectedCourse.id;

            const res = await this.callApi(
                "post",
                "quiz/save-quiz",
                this.quizData
            );

            if (res.status === 201 || res.status === 200) {
                this.info("Saving...");

                this.questionsData.quiz_id = res.data;
                this.saveQuestions();
            } else {
                console.log(res);
                this.swr();
            }

            this.isCreating = false;
        },
        async saveQuestions() {
            const res3 = await this.callApi(
                "post",
                "question/save-multiple-questions",
                this.questionsData
            );

            if (res3.status === 201 || res3.status === 200) {
                this.success("Quiz created successfully");
            }
        },
    },
    components: {
        Nav,
    },
    async created() {
        this.$store.commit("setCurrentPage", "quiz");

        this.token = window.Laravel.csrfToken;

        const res2 = await this.callApi("get", "course/get-courses");
        if (res2.status === 200) {
            this.coursesList = res2.data;
            console.log(this.coursesList);
        }

        if (this.$store.state.user.role == "Professor") {
            const res3 = await this.callApi(
                "get",
                "/get-professor-courses/" + this.user_id
            );
            if (res3.status === 200) {
                this.professorCoursesList = res3.data;
            }
        }
    },
};
</script>

<style lang="scss"></style>
