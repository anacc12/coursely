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
                    Lessons
                </h1>
                <router-link
                    v-bind:to="'/new-lesson'"
                    v-if="
                        $store.state.user.role == 'Admin' ||
                        $store.state.user.role == 'Professor'
                    "
                >
                    <Button
                        :loading="isLoading"
                        :disabled="isLoading"
                        class="c-btn c-btn--sml c-btn--primary u-display--flex--u"
                    >
                        New lesson
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
                <h1
                    class="u-type u-type--title u-type--title--base u-mb--sml--4"
                >
                    All lessons
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
                        class="c-card c-card--base c-card--primary"
                        v-for="(lesson, i) in lessons"
                        :key="i"
                        data-aos="zoom-out"
                        data-aos-delay="200"
                    >
                        <div
                            class="u-display--flex u-display--flex--jc--sb u-display--full"
                        >
                            <p class="u-type--title--sml">
                                {{ lesson.title }}
                            </p>
                            <div class="c-card__tag">{{ lesson.subject }}</div>
                        </div>
                        <div class="info-box">
                            <p class="u-type--base">
                                {{ lesson.description }}
                            </p>
                        </div>

                        <div
                            class="u-display--flex u-display--flex--gap--sml u-display--full"
                        >
                            <router-link
                                v-bind:to="'/edit-lesson/' + lesson.id"
                                class="u-display--full"
                                v-if="
                                    $store.state.user.role == 'Admin' ||
                                    lesson.user_id == $store.state.user.id
                                "
                            >
                                <Button
                                    :loading="isLoading"
                                    :disabled="isLoading"
                                    class="c-btn c-btn--sml c-btn--outline c-btn--full"
                                >
                                    Edit lesson
                                </Button>
                            </router-link>
                            <router-link
                                v-bind:to="'/lessons/' + lesson.id"
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

export default {
    data() {
        return {
            lessons: [],
            isLoading: false,
        };
    },
    components: {
        Nav,
    },
    methods: {},
    async created() {
        this.$store.commit("setCurrentPage", "lessons");
        const res = await this.callApi("get", "lesson/get-lessons");
        console.log("Lessons: " + res.data);
        if (res.status === 200) {
            this.lessons = res.data;
        } else console.log(res);
    },
};
</script>

<style lang="scss" scoped></style>
