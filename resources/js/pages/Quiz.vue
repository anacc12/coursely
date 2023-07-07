<template>
    <div class="u-display--flex">
        <div class="c-loader">
            <div class="c-loader__bar" :style="loaderStyle"></div>
        </div>
        <Nav />
        <div class="c-container c-container--main">
            <div class="recently">
                <div
                    class="title u-display--flex u-display--flex--jc--sb u-display--flex--fill u-display--flex--ai--start"
                >
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--fill"
                    >
                        <h1 class="u-type u-type--title u-type--title--lrg">
                            {{ quizData.title }}
                        </h1>
                        <div class="c-breadcrumbs__container">
                            <router-link to="/courses">
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
                            <router-link
                                v-bind:to="'/courses/' + this.course_id"
                            >
                                <Button class="c-btn--anchor">
                                    {{ course.title }}
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
                                {{ quizData.title }}
                            </Button>
                        </div>
                    </div>
                    <router-link
                        v-bind:to="
                            '/user-results/' + user_id + '/' + quizData.id
                        "
                    >
                        <Button
                            class="c-btn c-btn--sml c-btn--primary"
                            @click="saveResults"
                        >
                            Finish
                        </Button>
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
                <path stroke="#F1EFFB" d="M0 .5h1333" />
            </svg>

            <div class="c-container--content">
                <div class="c-container--split c-container--split--2">
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

                            <div
                                v-for="(question, ind) in questions"
                                :key="ind"
                            >
                                <div @click="showQuestionContent(question)">
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
                                                selectedTopic == question.text,
                                        }"
                                    >
                                        {{ question.text }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h1
                            class="u-type u-type--title u-type--title--base u-display--flex--fill u-mb--sml--4"
                        >
                            {{ selectedTopic }}
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
                        <div
                            class="c-container--cards"
                            v-if="this.questionContent"
                        >
                            <div
                                v-for="(questionOption, ind) in questionOptions"
                                :key="ind"
                                @click="selectOption(questionOption)"
                                class="c-card c-card--base c-card--secondary"
                                :class="
                                    selectedOptions.includes(questionOption)
                                        ? 'c-card--active'
                                        : ''
                                "
                            >
                                <div class="c-card__check"></div>
                                <p>{{ questionOption.text }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <div class="u-mb--sml--4">
                                <p
                                    class="u-type--title u-type--title--sml u-mb--sml--1"
                                >
                                    General information
                                </p>
                                <p class="u-type--base u-mb--sml--1">
                                    Successfully passing this quiz will ensure
                                    you get a certification for a
                                    {{ course.title }} course.
                                </p>
                                <p class="u-type--base">
                                    After you click on the "Finish" button, you
                                    will be able to see your results.
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
                                    Quiz information
                                </p>
                                <p class="u-type--base u-mb--sml--1">
                                    You can take up to 10 minutes for solving
                                    this quiz.
                                </p>
                                <p class="u-type--base u-mb--sml--1">
                                    Quiz will be successfully solved if you gain
                                    at least
                                    {{ quizData.passing_points }} points.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Nav from "../components/Nav";
import Footer from "../components/Footer";

export default {
    data() {
        return {
            course_id: this.$route.params.id,
            user_id: this.$store.state.user.id,
            quizData: [],
            questions: [],
            options: [],
            selectedOptions: [],
            total_points: null,
            finalData: {},
            course: [],
            selectedTopic: "Overview",
            questionContent: false,
            selectedQuestion: null,
            questionOptions: [],
            finishQuiz: false,
            countDown: 0,
        };
    },

    components: {
        Nav,
        Footer,
    },
    computed: {
        loaderStyle() {
            return {
                width: this.countDown / 1000 + "%",
            };
        },
    },
    methods: {
        countDownTimer() {
            if (this.countDown < 60000) {
                setTimeout(() => {
                    this.countDown += 1;
                    this.countDownTimer();
                }, 1);
            } else this.saveResults();
        },
        checkSelected(option) {
            return option.isSelected ? "c-card--active" : "";
        },
        showOverview() {
            this.selectedTopic = "Overview";
            this.questionContent = false;
        },
        showQuestionContent(question) {
            this.questionOptions = [];
            this.questionContent = true;

            this.options.forEach((option) => {
                if (option.question_id == question.id)
                    this.questionOptions.push(option);
            });

            this.selectedTopic = question.text;
        },
        selectOption(option) {
            if (option.selectCounter == 1) {
                option.selectCounter = 0;
                option.isSelected = false;
                this.selectedOptions.pop(option);
                this.total_points = this.total_points - option.points;
            } else {
                option.selectCounter = 0;
                option.selectCounter++;
                option.isSelected = true;
                this.selectedOptions.push(option);
                this.total_points = this.total_points + option.points;
            }
        },

        async saveResults() {
            const finalData = {
                user_id: this.user_id,
                total: this.total_points,
                quiz_id: this.quizData.id,
                passing: this.quizData.passing_points,
            };

            const res = await this.callApi("post", "/save-results", finalData);

            if (res.status === 200 || res.status === 201) {
                console.log(res);
                this.success("Results saved");
            } else {
                console.log(res);
                this.swr();
            }
        },
        async getOptions(question_id) {
            const res = await this.callApi(
                "get",
                "/get-question-options/" + question_id
            );

            if (res.status === 200 || res.status === 201) {
                var data = res.data;
                this.options.push(...data);
            }
        },
    },
    async created() {
        this.$store.commit("setCurrentPage", "my-courses");

        this.countDownTimer();
        this.$store.commit("setCurrentPage", "quiz");

        const re7 = await this.callApi(
            "get",
            "/get-course-with-lessons/" + this.course_id
        );
        if (re7.status === 200) {
            this.course = re7.data[0];
            console.log(re7.data[0]);
        } else console.log(re7);

        const res = await this.callApi(
            "get",
            "/get-course-quiz/" + this.course_id
        );

        if (res.status === 200) {
            this.quizData = res.data[0];
            console.log(res.data);
            const res2 = await this.callApi(
                "get",
                "/get-quiz-questions/" + this.quizData.id
            );
            if (res2.status === 200) {
                this.questions = res2.data;
                this.questions.forEach((question) => {
                    this.getOptions(question.id);
                });

                console.log("questions: " + this.questions);
                console.log("options: " + this.options);
            } else console.log(res2.data);
        } else console.log(res.data);
    },
};
</script>

<style lang="scss" scoped></style>
