<template>
    <div v-if="$store.state.user.status" class="u-display--flex">
        <Nav />
        <div class="c-container c-container--main u-display--full">
            <h1
                class="u-type u-type--title u-type--title--lrg u-display--flex--fill"
            >
                Hello, {{ $store.state.user.username }}!
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
                <h1
                    class="u-type u-type--title u-type--title--base u-mb--sml--4"
                >
                    Recent courses
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
                        v-for="(course, i) in recentCourses"
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

                <h1
                    class="u-type u-type--title u-type--title--base u-mb--sml--4 u-mt--sml--10"
                >
                    My recent courses
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
                        v-for="(course, i) in myRecentCourses"
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

                <b-row
                    class="u-mt--sml--10"
                    v-if="$store.state.user.role == 'Admin'"
                >
                    <h1
                        class="u-type u-type--title u-type--title--base u-mb--sml--4"
                    >
                        Quick actions
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
                    <div class="u-display--flex u-display--flex--gap--sml">
                        <router-link to="/lessons">
                            <Button class="c-btn c-btn--sml c-btn--outline">
                                Lessons
                            </Button>
                        </router-link>

                        <router-link to="/new-course">
                            <Button class="c-btn c-btn--sml c-btn--outline">
                                New course
                            </Button>
                        </router-link>
                        <router-link to="/new-lesson">
                            <Button class="c-btn c-btn--sml c-btn--outline">
                                New lesson
                            </Button>
                        </router-link>
                        <router-link to="/new-quiz">
                            <Button class="c-btn c-btn--sml c-btn--outline">
                                New quiz
                            </Button>
                        </router-link>
                    </div>
                </b-row>
            </b-container>
        </div>
    </div>
    <div v-else class="u-display--overflow--x0">
        <div class="c-container--home">
            <Nav />
            <b-container fluid class="c-container">
                <div class="c-hero">
                    <div
                        class="c-hero__copy"
                        data-aos="zoom-out"
                        data-aos-delay="100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="91"
                            height="8"
                            fill="none"
                            class="c-hero__line"
                        >
                            <path
                                fill="#661AE2"
                                d="M81.813 7.5c-2.5 0-3.8-1.7-4.9-3.2-1.1-1.4-2.1-2.8-4.1-2.8-2 0-3 1.4-4.1 2.8-1.1 1.5-2.4 3.2-4.9 3.2-2.5 0-3.8-1.7-4.9-3.2-1.1-1.4-2.1-2.8-4.1-2.8-2 0-3 1.4-4.1 2.8-1.1 1.5-2.4 3.2-4.9 3.2-2.5 0-3.8-1.7-4.9-3.2-1.1-1.4-2.1-2.8-4.1-2.8-2 0-3 1.4-4.1 2.8-1.1 1.5-2.4 3.2-4.9 3.2-2.5 0-3.8-1.7-4.9-3.2-1.1-1.4-2.1-2.8-4.1-2.8-2 0-3 1.4-4.1 2.8-1.1 1.5-2.4 3.2-4.9 3.2-2.5 0-3.8-1.7-4.9-3.2-1.1-1.4-2.1-2.8-4.1-2.8v-1c2.5 0 3.8 1.7 4.9 3.2 1.1 1.4 2.1 2.8 4.1 2.8 2 0 3-1.4 4.1-2.8 1.1-1.5 2.4-3.2 4.9-3.2 2.5 0 3.8 1.7 4.9 3.2 1.1 1.4 2.1 2.8 4.1 2.8 2 0 3-1.4 4.1-2.8 1.1-1.5 2.4-3.2 4.9-3.2 2.5 0 3.8 1.7 4.9 3.2 1.1 1.4 2.1 2.8 4.1 2.8 2 0 3-1.4 4.1-2.8 1.1-1.5 2.4-3.2 4.9-3.2 2.5 0 3.8 1.7 4.9 3.2 1.1 1.4 2.1 2.8 4.1 2.8 2 0 3-1.4 4.1-2.8 1.1-1.5 2.4-3.2 4.9-3.2 2.5 0 3.8 1.7 4.9 3.2 1.1 1.4 2.1 2.8 4.1 2.8 2 0 3-1.4 4.1-2.8 1.1-1.5 2.4-3.2 4.9-3.2v1c-2 0-3 1.4-4.1 2.8-1.1 1.5-2.4 3.2-4.9 3.2Z"
                            />
                        </svg>
                        <h1 class="c-hero__copy__title">
                            <!-- Unlock a world of new skills with Coursely! -->
                            Uncover a brand new world of knowledge!
                        </h1>
                        <p
                            class="c-hero__copy__description"
                            data-aos="zoom-out"
                            data-aos-delay="200"
                        >
                            Sharpen your skills and enchance your learning
                            experiences with Coursely, your ultimate learning
                            companion.
                        </p>
                        <div
                            class="u-display--flex u-display--flex--gap--sml u-mt--sml--4 sml-jc"
                        >
                            <router-link
                                v-if="!$store.state.user.status"
                                to="/register"
                            >
                                <Button class="c-btn c-btn--base c-btn--primary"
                                    >Start now</Button
                                >
                            </router-link>
                            <router-link
                                v-if="!$store.state.user.status"
                                to="/login"
                            >
                                <Button class="c-btn c-btn--base c-btn--outline"
                                    >Log in</Button
                                >
                            </router-link>
                        </div>
                    </div>
                    <img class="c-hero__image" :src="coursesImage" />
                </div>
                <div class="c-section">
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--lrg u-display--flex--ai--center"
                    >
                        <p class="c-section__title">
                            Explore a wide range of highly rated popular courses
                        </p>
                        <p class="c-section__description">
                            Discover exciting subjects, gain valuable skills,
                            and unlock your full potential through our online
                            learning platform.
                        </p>
                    </div>
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--med"
                    >
                        <div class="c-section--triple">
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="image" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                Laravel for beginners
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                40 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Jane Mayers
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Hard</div>
                                </div>

                                <p class="u-type--sml">
                                    Introduction to the Laravel framework,
                                    teaching the fundamentals for creating
                                    modern web applications.
                                </p>
                            </div>
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="pinkLogo" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                PHP Basics
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                32 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Robert Fox
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Medium</div>
                                </div>

                                <p class="u-type--sml">
                                    PHP programming language including how to
                                    write basic scripts, utilize existing
                                    functions, and more.
                                </p>
                            </div>
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="greenLogo" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                HTML & CSS
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                30 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Devon Laner
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Easy</div>
                                </div>

                                <p class="u-type--sml">
                                    Learn fundamentals of HTML and CSS,
                                    including the structure and styling of
                                    webpages.
                                </p>
                            </div>
                        </div>

                        <div class="c-section--triple">
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="greenLogo2" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                Intro to UX
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                29 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Kathryn Murphy
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Hard</div>
                                </div>

                                <p class="u-type--sml">
                                    Introduction to the user experience (UX)
                                    design, teaching the basics of usability,
                                    research, wireframing & prototyping.
                                </p>
                            </div>
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="lblueLogo" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                User Interface Design
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                29 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Savannah Nguyen
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Medium</div>
                                </div>

                                <p class="u-type--sml">
                                    Focusing on the principles and practices of
                                    designing user-friendly software interfaces
                                    for applications and websites.
                                </p>
                            </div>
                            <div
                                class="c-card c-card--primary u-display--flex--fill"
                            >
                                <div
                                    class="u-display--flex u-display--flex--jc--sb u-display--full"
                                >
                                    <div
                                        class="u-display--flex u-display--flex--gap--sml"
                                    >
                                        <img :src="lpinkLogo" alt />
                                        <div
                                            class="u-display--flex u-display--flex--col"
                                        >
                                            <p class="u-type--title--sml">
                                                C# Programming
                                            </p>
                                            <p
                                                class="u-type--sml u-type--sml--accent"
                                            >
                                                26 people enrolled
                                            </p>
                                            <p class="u-type--sml">
                                                Kristin Watson
                                            </p>
                                        </div>
                                    </div>
                                    <div class="c-card__tag">Hard</div>
                                </div>

                                <p class="u-type--sml">
                                    From basic syntax to more advanced topics
                                    such as object-oriented programming and web
                                    development.
                                </p>
                            </div>
                        </div>
                    </div>
                    <router-link
                        v-if="!$store.state.user.status"
                        to="/register"
                    >
                        <Button class="c-btn c-btn--base c-btn--primary"
                            >Start learning now</Button
                        >
                    </router-link>
                </div>
                <div class="c-section c-section--color">
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--lrg u-display--flex--ai--center"
                    >
                        <p class="c-section__title">
                            Challenge your knowledge before earning a
                            certificate!
                        </p>
                        <p class="c-section__description">
                            Put your knowledge to the test and ensure you're
                            fully prepared to earn your well-deserved
                            certificate.
                        </p>
                    </div>

                    <img :src="quiz" class="c-section__image--lrg" />

                    <div
                        class="u-display--flex u-display--flex--gap--sml u-mt--sml--4"
                    >
                        <router-link
                            v-if="!$store.state.user.status"
                            to="/register"
                        >
                            <Button class="c-btn c-btn--base c-btn--primary"
                                >Get certified</Button
                            >
                        </router-link>
                        <router-link
                            v-if="!$store.state.user.status"
                            to="/login"
                        >
                            <Button class="c-btn c-btn--base c-btn--outline"
                                >Continue learning</Button
                            >
                        </router-link>
                    </div>
                </div>

                <div class="c-section">
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--lrg u-display--flex--ai--center"
                    >
                        <p class="c-section__title">
                            Discover trending subjects and in-demand courses
                        </p>
                        <p class="c-section__description">
                            Stay ahead of the curve by discovering our selection
                            of popular subjects in today's market.
                        </p>
                    </div>
                    <div
                        class="u-display--flex u-display--flex--gap--base u-display--flex--wrap"
                    >
                        <div class="c-card__tag c-card__tag--lrg">
                            Technology
                        </div>
                        <div class="c-card__tag c-card__tag--lrg">Business</div>
                        <div class="c-card__tag c-card__tag--lrg">Language</div>
                        <div class="c-card__tag c-card__tag--lrg">Arts</div>
                        <div class="c-card__tag c-card__tag--lrg">Science</div>
                        <div class="c-card__tag c-card__tag--lrg">Economy</div>
                    </div>
                    <img :src="coursesWide" class="c-section__image--xlrg" />
                    <router-link
                        v-if="!$store.state.user.status"
                        to="/register"
                    >
                        <Button class="c-btn c-btn--base c-btn--primary"
                            >Start learning now</Button
                        >
                    </router-link>
                </div>
            </b-container>
            <Footer />
        </div>
    </div>
</template>

<script>
import Nav from "../components/Nav";
import image from "../assets/blue-logo.png";
import coursesWide from "../assets/courses-wide-2.png";
import pinkLogo from "../assets/dpink.png";
import redLogo from "../assets/rlogo.png";
import greenLogo from "../assets/glogo.png";
import greenLogo2 from "../assets/lgren2.png";
import blackLogo from "../assets/blogo.png";
import lblueLogo from "../assets/lblue.png";
import lpinkLogo from "../assets/lpink.png";
import coursesImage from "../assets/courses-margin-light.png";
import quiz from "../assets/quiz-light.png";
import Footer from "../components/Footer";

export default {
    data() {
        return {
            image: image,
            coursesImage: coursesImage,
            pinkLogo: pinkLogo,
            redLogo: redLogo,
            greenLogo: greenLogo,
            greenLogo2: greenLogo2,
            blackLogo: blackLogo,
            lblueLogo: lblueLogo,
            lpinkLogo: lpinkLogo,
            quiz: quiz,
            coursesWide: coursesWide,
            courses: [],
            isLoading: false,
            courseProfessor: null,
            professors: [],
            profs: [],
            profName: "",
            show: false,
            recentCourses: [],
            myCourses: [],
            myRecentCourses: [],
        };
    },
    components: {
        Nav,
        Footer,
    },
    methods: {
        getProf(course) {
            this.profs.forEach((prof) => {
                if (prof.id == course.professor_id) {
                    this.profName = prof.firstName + "" + prof.lastName;
                }
            });
        },

        async getAllCourses() {
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
        this.$store.commit("setCurrentPage", "home");

        if (this.$store.state.user.status) {
            const res = await this.callApi("get", "course/get-courses-lessons");

            console.log(res.data);

            if (res.status === 200) {
                this.courses = res.data;
            } else console.log(res);

            this.courses.forEach((course, i) => {
                if (
                    // i === this.courses.length - 8 ||
                    // i === this.courses.length - 7 ||
                    // i === this.courses.length - 6 ||
                    // i === this.courses.length - 5 ||
                    i === this.courses.length - 4 ||
                    i === this.courses.length - 3 ||
                    i === this.courses.length - 2 ||
                    i === this.courses.length - 1
                ) {
                    this.recentCourses.push(course);
                }
            });

            this.courses.forEach((course) => {
                this.professors.push(course.professor_id);
            });
            this.professors.forEach(async (prof_id) => {
                const res6 = await this.callApi("get", "/get-user/" + prof_id);
                this.profs.push(res6.data);
            });

            this.id = this.$store.state.user.id;
            console.log(this.id);

            if (this.$store.state.user.role == "Professor") {
                const res = await this.callApi(
                    "get",
                    "/get-professor-courses/" + this.id
                );
                if (res.status === 200) {
                    this.myCourses = res.data;
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
                    this.myCourses = res.data;
                } else {
                    console.log(res);
                    this.swr();
                }
            }

            this.myCourses.forEach((course, i) => {
                if (
                    i === this.myCourses.length - 8 ||
                    i === this.myCourses.length - 7 ||
                    i === this.myCourses.length - 6 ||
                    i === this.myCourses.length - 5 ||
                    i === this.myCourses.length - 4 ||
                    i === this.myCourses.length - 3 ||
                    i === this.myCourses.length - 2 ||
                    i === this.myCourses.length - 1
                ) {
                    this.myRecentCourses.push(course);
                }
            });
        }
    },
};
</script>

<style lang="scss" scoped></style>
