<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div class="u-display--flex u-display--flex--col u-mb--sml--4">
                <h1 class="u-type u-type--title u-type--title--lrg">
                    Create a lesson
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
                            action="lesson/uploadPdf"
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
                        >
                            <Button
                                class="c-btn c-btn--sml c-btn--primary u-display--flex--u"
                                >Add pdf</Button
                            >
                        </Upload>
                    </div>

                    <div v-if="this.$store.state.course_id != null">
                        <div
                            class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                        >
                            <label class="c-input__label">Course subject</label>
                            <p class="u-type--base">{{ course.subject }}</p>
                        </div>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                        v-if="this.$store.state.course_id == null"
                    >
                        <label class="c-input__label" for="subject"
                            >Subject</label
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
                        <label class="c-input__label" for="title"
                            >Description</label
                        >
                        <b-form-input
                            v-model="lessonData.description"
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
            lessonData: {
                title: "",
                subject: "",
                description: "",
                user_id: this.$store.state.user.id,
            },
            isCreating: false,
            token: "",
            subjectsList: [],
            selectedSubject: {},
            course: [],
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
            if (this.lessonData.title.trim() == "")
                return this.error("Title is required");

            if (this.lessonData.description.trim() == "")
                return this.error("Description is required");
            else {
                this.saveLesson();
            }
        },
        async saveLesson() {
            this.isCreating = true;
            this.lessonData.subject = this.selectedSubject.title;

            if (this.$store.state.course_id != null) {
                console.log("Ldata userid: " + this.lessonData.user_id);
                this.lessonData.course_id = this.$store.state.course_id;
                this.lessonData.subject = this.course.subject;
                const res = await this.callApi(
                    "post",
                    "lesson/save-lesson-for-course",
                    this.lessonData
                );

                this.success("Lesson added successfully!");

                this.$router.push({
                    path: "/courses/" + this.$store.state.course_id,
                });

                if (res.status == 200 || res.status == 201) {
                    this.lessonData.title = JSON.parse(res.data.title);
                    this.lessonData.description = JSON.parse(
                        res.data.description
                    );
                } else {
                    console.log(res);
                    this.swr();
                }
            } else {
                const res = await this.callApi(
                    "post",
                    "lesson/save-lesson",
                    this.lessonData
                );

                if (res.status == 200 || res.status == 201) {
                    console.log(res);
                    //String to Array
                    this.lessonData.title = JSON.parse(res.data.title);
                    this.lessonData.description = JSON.parse(
                        res.data.description
                    );
                    this.success("lesson created successfully, redirecting...");
                    this.$router.push({ path: "/lessons" });
                } else {
                    console.log(res);
                    this.swr();
                }
            }

            this.isCreating = false;

            this.$store.state.course_id = null;
        },
    },
    components: {
        Nav,
    },
    async created() {
        this.$store.commit("setCurrentPage", "lessons");

        this.token = window.Laravel.csrfToken;

        const res = await this.callApi("get", "/get-subjects");
        if (res.status === 200) {
            this.subjectsList = res.data;
        }

        if (this.$store.state.course_id != null) {
            const res2 = await this.callApi(
                "get",
                "/get-course-with-lessons/" + this.$store.state.course_id
            );
            if (res2.status === 200) {
                this.course = res2.data[0];
            } else console.log(res2);
        }

        console.log(this.$store.state.course_id);

        console.log(this.course);
    },
};
</script>

<style lang="scss"></style>
