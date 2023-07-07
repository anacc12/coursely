<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div class="u-display--flex u-display--flex--col u-mb--sml--4">
                <h1 class="u-type u-type--title u-type--title--lrg">
                    Edit lesson
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
                            >Lesson title</label
                        >
                        <b-form-input
                            v-model="lessonData.title"
                            class="Lesson"
                            type="text"
                        ></b-form-input>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="title"
                            >Lesson pdf</label
                        >
                        <Upload
                            ref="uploads"
                            action="/edit-lesson/uploadPdf"
                            :headers="{
                                'x-csrf-token': token,
                                'X-Requested-With': 'XMLHttpRequest',
                            }"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['pdf']"
                            :on-format-error="handleFormatError"
                            :max-size="2048"
                            :on-exceeded-size="handleMaxSize"
                            v-model="lessonData.pdf"
                        >
                            <Button v-if="!lessonData.pdf">Add pdf</Button>
                            <Button
                                v-if="lessonData.pdf"
                                class="c-btn c-btn--sml c-btn--outline u-display--flex--u"
                                >{{ lessonData.pdf }}</Button
                            >
                        </Upload>
                    </div>
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label"
                            >Subject (current: {{ previousSubject }})</label
                        >
                        <b-select
                            class="form-control"
                            v-model="selectedSubject"
                        >
                            <option :value="''" disabled selected>
                                Select a subject
                            </option>
                            <option
                                v-for="subject in subjectsList"
                                :key="subject.id"
                                :value="subject"
                            >
                                {{ subject.title }}
                            </option>
                        </b-select>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label">Description</label>
                        <b-form-input
                            v-model="lessonData.description"
                            class="Lesson"
                            type="text"
                        ></b-form-input>
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
                    <div
                        class="u-display--flex u-display--flex--jc--sb u-display--flex--fill"
                    >
                        <router-link to="/">
                            <Button class="c-btn c-btn--base c-btn--outline"
                                >Cancel</Button
                            >
                        </router-link>
                        <Button
                            @click="validateLesson"
                            class="c-btn c-btn--base c-btn--primary u-display--flex--u"
                            :loading="isCreating"
                            :disabled="isCreating"
                        >
                            Update lesson
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
            id: this.$route.params.id,
            lessonData: {
                title: "",
                subject: "",
                description: "",
            },
            previousSubject: {},
            isCreating: false,
            token: "",
            subjectsList: [],
            selectedSubject: {},
        };
    },

    methods: {
        handleSuccess(res, file) {
            res = `/uploads/${res}`;
            // console.log(res);
            this.lessonData.pdf = res;
            this.$refs.uploads.clearFiles();
        },
        handleError(res, file) {
            console.log(file);
            this.$Notice.warning({
                title: `${file.message}`,
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong"
                }`,
            });
        },
        handleFormatError(file) {
            console.log(file);
            this.$Notice.warning({
                title: "File format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select only pdf",
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File" + file.name + "is too big",
            });
        },

        validateLesson() {
            this.saveLesson();
        },
        async saveLesson() {
            this.isCreating = true;
            this.lessonData.subject =
                this.selectedSubject.title || this.previousSubject;
            const res = await this.callApi(
                "post",
                "/edit-lesson",
                this.lessonData
            );

            if (res.status === 200 || res.status === 201) {
                console.log(res);
                this.success("Lesson updated successfully!");
                this.$router.push({ path: "/lessons" });
            } else {
                console.log(res);
                this.swr();
            }
            this.isCreating = false;
        },
    },
    components: {
        Nav,
    },
    async created() {
        this.$store.commit("setCurrentPage", "lessons");
        this.token = window.Laravel.csrfToken;

        const res = await this.callApi("get", "/get-lesson/" + this.id);

        if (res.status === 200) {
            console.log(res);
            this.lessonData = res.data[0];
            this.lessonData.title = res.data[0].title;
            this.lessonData.subject = res.data[0].subject;
            this.lessonData.description = res.data[0].description;
            this.lessonData.pdf = res.data[0].pdf;
            this.previousSubject = res.data[0].subject;
        } else console.log(res);

        const res2 = await this.callApi("get", "/get-subjects");
        if (res2.status === 200) {
            this.subjectsList = res2.data;
            console.log("subjects list: " + res2.data);
        }
    },
};
</script>

<style lang="scss"></style>
