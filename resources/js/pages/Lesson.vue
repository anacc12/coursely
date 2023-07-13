<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div>
                <div
                    class="title u-display--flex u-display--flex--jc--sb u-display--flex--fill u-display--flex--ai--start"
                >
                    <h1 class="u-type u-type--title u-type--title--lrg">
                        {{ lesson.title }}
                    </h1>
                    <div class="u-display--flex u-display--flex--gap--sml">
                        <Button
                            v-if="lesson.pdf != null"
                            class="c-btn c-btn--sml c-btn--outline"
                            :loading="isCreating"
                            :disabled="isCreating"
                            @click="downloadPdf()"
                        >
                            Download pdf
                        </Button>
                        <router-link
                            v-if="
                                user_id == lesson.user_id ||
                                $store.state.user.role == 'Admin'
                            "
                            v-bind:to="'/edit-lesson/' + this.id"
                        >
                            <Button class="c-btn c-btn--sml c-btn--outline"
                                >Edit lesson</Button
                            >
                        </router-link>
                        <router-link
                            v-if="$store.state.user.role != 'Student'"
                            to="/new-lesson"
                        >
                            <Button
                                class="c-btn c-btn--sml c-btn--primary"
                                :loading="isCreating"
                                :disabled="isCreating"
                            >
                                New lesson
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

                <b-container class="c-container--content">
                    <h1
                        class="u-type u-type--title u-type--title--base u-display--flex--fill"
                    >
                        Overview
                    </h1>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="100%"
                        height="1"
                        fill="none"
                    >
                        <path stroke="#F1EFFB" d="M0 .5h1333" />
                    </svg>

                    <p class="u-type--title u-type--title--sml u-mb--sml--1">
                        Subject
                    </p>
                    <p class="u-type--base">
                        {{ lesson.subject }}
                    </p>
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
                            Description
                        </p>
                        <p class="u-type--base">
                            {{ lesson.description }}
                        </p>
                    </div>
                </b-container>
            </div>
        </b-container>
    </div>
</template>

<script>
import Nav from "../components/Nav";
import Footer from "../components/Footer";
import avatar from "../assets/avatar.png";

export default {
    data() {
        return {
            user_id: this.$store.state.user.id,
            id: this.$route.params.id,
            lesson: [],
            avatar: avatar,
            isCreating: false,
            isEditing: false,
        };
    },

    methods: {
        downloadPdf() {
            axios({
                url: "http://localhost:8000" + this.lesson.pdf, // File URL Goes Here
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
    },

    components: {
        Nav,
        Footer,
    },

    async created() {
        this.$store.commit("setCurrentPage", "lessons");

        const res = await this.callApi("get", "/get-lesson/" + this.id);

        if (res.status === 200) {
            this.lesson = res.data[0];
            this.lesson.title = JSON.parse(res.data[0].title);
            this.lesson.subject = JSON.parse(res.data[0].subject);
            this.lesson.description = JSON.parse(res.data[0].description);
        } else console.log(res);
    },
};
</script>

<style lang="scss" scoped></style>
