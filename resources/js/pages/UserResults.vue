<template>
    <div class="u-display--flex">
        <Nav />

        <b-container class="c-container c-container--main">
            <div class="u-display--flex u-display--flex--col u-mb--sml--4">
                <h1 class="u-type u-type--title u-type--title--lrg">
                    Quiz results
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
                    class="c-card"
                    :class="
                        userResults.result == 'pass'
                            ? 'c-card--success'
                            : 'c-card--fail'
                    "
                >
                    <img class="c-card--success__img" />
                    <div class="c-card--success__content">
                        <p
                            class="c-card--success__content__title"
                            v-if="userResults.result == 'pass'"
                        >
                            Congratulations!
                        </p>
                        <p v-else class="c-card--fail__content__title">
                            Sorry! Better luck next time :)
                        </p>
                        <p
                            class="u-type--base"
                            v-if="userResults.result == 'pass'"
                        >
                            Download your certificate by clicking on the link
                            below.
                        </p>
                        <p class="u-type--base" v-else>Try again later.</p>
                    </div>
                    <Button
                        class="c-btn c-btn--sml c-btn--primary"
                        v-if="userResults.result == 'pass'"
                        @click="generatePDF()"
                        >Download</Button
                    >
                    <Button
                        class="c-btn c-btn--sml c-btn--outline--fail"
                        v-if="userResults.result == 'fail'"
                        @click="redirect()"
                        >Back to course</Button
                    >
                </div>

                <vue-html2pdf
                    :show-layout="false"
                    :float-layout="true"
                    :enable-download="true"
                    :preview-modal="true"
                    :paginate-elements-by-height="1400"
                    filename="myPDF"
                    :pdf-quality="2"
                    :manual-pagination="false"
                    pdf-format="a4"
                    pdf-orientation="landscape"
                    pdf-content-width="800px"
                    ref="html2Pdf"
                    @progress="onProgress($event)"
                >
                    <section slot="pdf-content">
                        <div class="c-card c-card--ghost height--100">
                            <img class="c-card--success__img" />
                            <div class="c-card--success__content">
                                <p class="c-card--success__content__title">
                                    Successfully finished {{ course_name }}
                                </p>

                                <p class="u-type--base">
                                    {{ user.firstName }} {{ user.lastName }}
                                </p>
                                <p class="u-type--sml">
                                    {{ user.email }}
                                </p>
                            </div>
                        </div>
                    </section>
                </vue-html2pdf>
            </b-container></b-container
        >
    </div>
</template>

<script>
import Nav from "../components/Nav";
import Footer from "../components/Footer";
import VueHtml2pdf from "vue-html2pdf";

export default {
    data() {
        return {
            quiz_id: this.$route.params.quiz_id,
            user_id: this.$store.state.user.id,
            userResults: [],
            user: [],
            course_id: null,
            course_name: "",
        };
    },

    components: {
        Nav,
        Footer,
        VueHtml2pdf,
    },

    methods: {
        redirect() {
            this.$router.push({ path: "/my-courses/" + this.course_id });
        },
        generateReport() {
            this.$refs.html2Pdf.generatePdf();
        },
        onProgress(event) {
            console.log(`Processed: ${event} / 100`);
        },
        hasGenerated() {
            alert("PDF generated successfully!");
        },
        generatePDF() {
            this.$refs.html2Pdf.generatePdf();
        },
    },
    async created() {
        this.$store.commit("setCurrentPage", "my-courses");

        const res = await this.callApi(
            "get",
            "/get-user-results/" + this.user_id + "/" + this.quiz_id
        );
        if (res.status === 200 || res.status === 201) {
            this.user = res.data[0];
            this.userResults = res.data[0].user_quizzes[0].pivot;
            this.course_id = res.data[0].user_quizzes[0].course_id;

            const res2 = await this.callApi(
                "get",
                "/get-course/" + this.course_id
            );
            if (res2.status === 200 || res2.status === 201) {
                this.course_name = res2.data.title;
                console.log(res2);
            }
        }
    },
};
</script>

<style lang="scss" scoped></style>
