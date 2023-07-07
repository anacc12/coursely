<template>
    <div>
        <Nav />
        <b-container class="">
            <b-row>
                <b-col cols="6" class="lessons">
                    <div class="title-lesson">
                        <h2>Lesson single</h2>
                    </div>
                    <b-row class="lesson-list">
                        <b-col cols="2">
                            <div class="grams">
                                <h2>Title: {{ lesson.title }}</h2>
                                <div class="pdf">
                                    <p>{{ lesson.pdf }}</p>
                                </div>
                            </div>
                            <h2 class="lesson">
                                Subject: {{ lesson.subject }}
                            </h2>
                            <p>Description: {{ lesson.description }}</p>
                        </b-col>
                    </b-row>
                </b-col>

                <div class="buttons">
                    <router-link
                        v-if="$store.state.user.role != 'Student'"
                        to="/new-lesson"
                    >
                        <Button
                            class="start-btn"
                            :loading="isCreating"
                            :disabled="isCreating"
                        >
                            New lesson
                        </Button>
                    </router-link>
                    <Button
                        class="start-btn"
                        :loading="isCreating"
                        :disabled="isCreating"
                        @click="downloadPdf()"
                    >
                        Download pdf
                    </Button>
                    <router-link
                        v-if="user_id == lesson.user_id"
                        v-bind:to="'/edit-lesson/' + this.id"
                    >
                        <Button class="login-btn">Edit lesson</Button>
                    </router-link>
                </div>
            </b-row>
        </b-container>
        <Footer />
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
