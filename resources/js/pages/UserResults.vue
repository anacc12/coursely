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
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="160"
                        height="160"
                        fill="none"
                        v-if="userResults.result == 'pass'"
                    >
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-width="1.7"
                            d="M143.15 80c0 34.876-28.274 63.15-63.15 63.15S16.85 114.876 16.85 80 45.124 16.85 80 16.85 143.15 45.124 143.15 80Z"
                        />
                        <path
                            fill="#661AE2"
                            stroke="#39196D"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M124.851 33.088a1.156 1.156 0 0 1 .817.611 1.158 1.158 0 0 1 .011 1.02l-4.623 9.517a1.147 1.147 0 0 1-2.182-.459l-.392-10.435a1.148 1.148 0 0 1 1.355-1.173l5.014.919ZM101.363 33.76a1.15 1.15 0 0 0-.733 1.677l5.154 9.24a1.15 1.15 0 0 0 1.922.13c.154-.205.235-.455.23-.711l-.199-10.442a1.15 1.15 0 0 0-1.419-1.094l-4.955 1.2ZM59.96 38.525a1.15 1.15 0 0 0-1.78.427l-4.252 9.688a1.149 1.149 0 0 0 1.76 1.364l8.201-6.464a1.149 1.149 0 0 0 .016-1.794l-3.945-3.22ZM40.389 31.613a1.148 1.148 0 0 0-1.157 1.418l2.475 10.286a1.149 1.149 0 0 0 2.229.02l2.624-10.11a1.148 1.148 0 0 0-1.072-1.44l-5.1-.174Z"
                        />
                        <path
                            fill="#fff"
                            d="M49.28 66.49c-.235-5.174-1.16-16.207-5.414-15.585a3.098 3.098 0 0 0-2.621 3.52l.149 1.024c1.097 7.504-1.012 15.827-7.308 16.747l2.288 15.693.8-.117c3.936-.576 6.197 1.882 13.245.852l11.949-1.744a2.76 2.76 0 0 0-.8-5.46l1.365-.198a2.76 2.76 0 0 0-.8-5.46l1.365-.198a2.76 2.76 0 0 0-.8-5.459l1.363-.198a2.76 2.76 0 0 0-.8-5.46L49.28 66.49Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m46.554 66.888 2.73-.399M61.57 81.418l-1.365.2M62.136 75.76l-1.363.2M62.704 70.103l-1.365.2"
                        />
                        <path
                            fill="#661AE2"
                            d="M32.408 89.33a1.895 1.895 0 0 1-1.6 2.152l-11.91 2.13a73.397 73.397 0 0 1-1.12-12.87c0-2.886.166-5.77.494-8.64l9.92-1.825a1.42 1.42 0 0 1 1.619 1.198l2.597 17.855Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M18.269 72.119v-.02l9.92-1.825a1.42 1.42 0 0 1 1.62 1.198l2.607 17.858a1.895 1.895 0 0 1-1.6 2.152l-11.91 2.131"
                        />
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m32.49 89.85 2.209-.32a1.906 1.906 0 0 0 1.6-2.16l-2.142-14.655a1.904 1.904 0 0 0-2.159-1.6l-2.21.32 2.701 18.414Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M49.28 66.49c-.235-5.174-1.16-16.207-5.414-15.585a3.098 3.098 0 0 0-2.621 3.52l.149 1.024c1.097 7.504-1.012 15.827-7.308 16.747l2.288 15.693.8-.117c3.936-.576 6.197 1.882 13.245.852l11.949-1.744a2.76 2.76 0 0 0-.8-5.46l1.365-.198a2.76 2.76 0 0 0-.8-5.46l1.365-.198a2.76 2.76 0 0 0-.8-5.459l1.363-.198a2.76 2.76 0 0 0-.8-5.46L49.28 66.49Z"
                        />
                        <path
                            fill="#fff"
                            d="M110.314 66.49c.235-5.174 1.16-16.207 5.414-15.585a3.102 3.102 0 0 1 2.56 2.31c.1.396.121.807.061 1.21l-.149 1.024c-1.097 7.504 1.011 15.827 7.307 16.747l-2.288 15.693-.8-.117c-3.934-.576-6.196 1.882-13.244.852L97.229 86.88a2.759 2.759 0 0 1 .8-5.46l-1.365-.198a2.759 2.759 0 0 1 .8-5.46l-1.365-.198a2.759 2.759 0 0 1 .8-5.459l-1.365-.198a2.759 2.759 0 0 1 .8-5.46l13.98 2.042Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m113.043 66.888-2.73-.399M98.027 81.418l1.365.2M97.46 75.76l1.366.2M96.894 70.103l1.365.2"
                        />
                        <path
                            fill="#661AE2"
                            d="M141.841 80.32c0 4.294-.368 8.58-1.104 12.813L128.8 91.482a1.887 1.887 0 0 1-1.582-1.41 1.9 1.9 0 0 1-.037-.743l2.604-17.857a1.443 1.443 0 0 1 1.637-1.2l9.906 1.352c.344 2.886.516 5.79.513 8.696Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M140.737 93.136 128.8 91.482a1.887 1.887 0 0 1-1.582-1.41 1.9 1.9 0 0 1-.037-.743l2.604-17.857a1.443 1.443 0 0 1 1.637-1.2l9.906 1.352"
                        />
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m127.109 89.85-2.212-.32a1.903 1.903 0 0 1-1.608-2.16l2.151-14.656a1.902 1.902 0 0 1 2.158-1.6l2.211.32-2.7 18.416Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M110.314 66.49c.235-5.174 1.16-16.207 5.414-15.585a3.102 3.102 0 0 1 2.56 2.31c.1.396.121.807.061 1.21l-.149 1.024c-1.097 7.504 1.011 15.827 7.307 16.747l-2.288 15.693-.8-.117c-3.934-.576-6.196 1.882-13.244.852L97.229 86.88a2.759 2.759 0 0 1 .8-5.46l-1.365-.198a2.759 2.759 0 0 1 .8-5.46l-1.365-.198a2.759 2.759 0 0 1 .8-5.459l-1.365-.198a2.759 2.759 0 0 1 .8-5.46l13.98 2.042Z"
                        />
                        <path
                            fill="#fff"
                            d="M75.31 105.8c.537-6.947 2.24-21.752 7.944-20.736a4.177 4.177 0 0 1 3.378 4.845l-.245 1.371c-1.795 10.05.69 21.335 9.12 22.839l-3.742 21.014-1.079-.192c-5.268-.941-8.416 2.269-17.854.584l-15.987-2.853a3.71 3.71 0 1 1 1.304-7.308l-1.827-.32a3.714 3.714 0 0 1-1.47-6.7 3.718 3.718 0 0 1 2.775-.609l-1.827-.32a3.712 3.712 0 0 1 1.304-7.309l-1.827-.32a3.714 3.714 0 0 1-3.002-4.306 3.71 3.71 0 0 1 4.306-3.003l18.73 3.323Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m78.965 106.453-3.654-.653M58.149 125.363l1.827.325M57.627 117.728l1.827.324M57.104 110.093l1.827.326"
                        />
                        <path
                            fill="#661AE2"
                            d="M131.315 116.741a72.673 72.673 0 0 1-32.835 23.368l-.074-.018a1.85 1.85 0 0 1-1.484-2.153l4.398-24.668a1.849 1.849 0 0 1 2.154-1.504l27.841 4.975Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M98.5 140.109h-.02l-.074-.018a1.85 1.85 0 0 1-1.484-2.153l4.398-24.668a1.849 1.849 0 0 1 2.154-1.504l27.84 4.975"
                        />
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="m96.912 137.937-3.655-.657a1.857 1.857 0 0 1-1.5-2.152l3.75-21.015a1.858 1.858 0 0 1 2.154-1.501l3.654.653-4.403 24.672Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M75.31 105.8c.537-6.947 2.24-21.752 7.944-20.736a4.177 4.177 0 0 1 3.378 4.845l-.245 1.371c-1.795 10.05.69 21.335 9.12 22.839l-3.742 21.014-1.079-.192c-5.268-.941-8.416 2.269-17.854.584l-15.987-2.853a3.71 3.71 0 1 1 1.304-7.308l-1.827-.32a3.714 3.714 0 0 1-1.47-6.7 3.718 3.718 0 0 1 2.775-.609l-1.827-.32a3.712 3.712 0 0 1 1.304-7.309l-1.827-.32a3.714 3.714 0 0 1-3.002-4.306 3.71 3.71 0 0 1 4.306-3.003l18.73 3.323Z"
                        />
                    </svg>

                    <svg
                        v-if="userResults.result != 'pass'"
                        xmlns="http://www.w3.org/2000/svg"
                        width="160"
                        height="160"
                        fill="none"
                    >
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-width="1.7"
                            d="M35.346 124.654a63.15 63.15 0 1 1 89.31-89.308 63.15 63.15 0 0 1-89.31 89.308Z"
                        />
                        <path
                            fill="#fff"
                            d="M95.576 59.663c-7.418 0-10.928-5.144-24.213-5.144H48.857a5.144 5.144 0 1 0 0 10.288h-2.572a5.144 5.144 0 1 0 0 10.287h-2.572a5.144 5.144 0 0 0 0 10.289h-2.572a5.144 5.144 0 1 0 0 10.288h26.363c-.96 9.608-2.232 30.22 5.787 30.22a5.785 5.785 0 0 0 5.787-5.787v-1.929c0-14.146 6.136-28.935 18.005-28.935V59.663h-1.507Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M72.648 95.67h-5.144M48.857 64.807h2.572M46.285 75.095h2.573M43.713 85.383h2.572"
                        />
                        <path
                            fill="#F73759"
                            d="m141.5 93.915-35.1.47a1.6 1.6 0 0 1-1.6-1.6V56.118a1.6 1.6 0 0 1 1.6-1.6h30.803S141.62 65.855 142.5 73.5c.912 7.93-1 20.415-1 20.415Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M141 94.384h-34.6a1.6 1.6 0 0 1-1.6-1.6V56.12a1.6 1.6 0 0 1 1.6-1.6h30.803"
                        />
                        <path
                            fill="#fff"
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M104.8 57.09h-6.117a1.6 1.6 0 0 0-1.6 1.6v31.52a1.6 1.6 0 0 0 1.6 1.6h6.117V57.09Z"
                        />
                        <path
                            stroke="#39196D"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M95.576 59.663c-7.418 0-10.928-5.144-24.213-5.144H48.857a5.144 5.144 0 1 0 0 10.288h-2.572a5.144 5.144 0 1 0 0 10.287h-2.572a5.144 5.144 0 0 0 0 10.289h-2.572a5.144 5.144 0 1 0 0 10.288h26.363c-.96 9.608-2.232 30.22 5.787 30.22a5.785 5.785 0 0 0 5.787-5.787v-1.929c0-14.146 6.136-28.935 18.005-28.935V59.663h-1.507Z"
                        />
                    </svg>
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
