<template>
    <div class="u-display--flex">
        <Nav />
        <b-container class="c-container c-container--main">
            <div class="u-display--flex u-display--flex--col u-mb--sml--4">
                <h1 class="u-type u-type--title u-type--title--lrg">
                    Create a course
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
                            >Course name</label
                        >
                        <b-form-input
                            v-model="courseData.title"
                            class="Course"
                            type="text"
                        ></b-form-input>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label">Description</label>
                        <b-form-input
                            v-model="courseData.description"
                            class="Course"
                            type="text"
                        ></b-form-input>
                    </div>
                    <Upload
                        ref="uploads"
                        action="course/upload"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        }"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-format-error="handleFormatError"
                        :max-size="2048"
                        :on-exceeded-size="handleMaxSize"
                    >
                        <img
                            v-if="courseData.image"
                            class="c-img c-img--upload"
                            :src="courseData.image"
                            alt
                        />

                        <Button
                            v-if="!courseData.image"
                            class="c-btn c-btn--sml c-btn--primary u-display--flex--u"
                            >Add image</Button
                        >
                        <Button
                            v-else
                            class="c-btn c-btn--sml c-btn--outline u-display--flex--u"
                            >Edit image</Button
                        >
                    </Upload>
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="professor"
                            >Professor</label
                        >
                        <b-select
                            class="form-control"
                            @change="printSelected"
                            v-model="selectedProfessor"
                        >
                            <option :value="''" disabled selected>
                                Select a professor
                            </option>
                            <option
                                v-for="professor in professorsList"
                                :key="professor.id"
                                :value="professor"
                            >
                                {{ professor.firstName }}
                                {{ professor.lastName }} (
                                {{ professor.email }})
                            </option>
                        </b-select>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="subject"
                            >Subject</label
                        >
                        <b-select
                            class="form-control"
                            v-model="selectedSubject"
                            @change="printSubject"
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
                        <label class="c-input__label" for="multi-lesson"
                            >Lessons</label
                        >

                        <multiselect
                            v-model="value"
                            :options="lessonsList"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            placeholder="Select one or more lessons"
                            label="title"
                            track-by="title"
                            @input="showMultiSelectedOptions"
                        >
                            <template
                                slot="selection"
                                slot-scope="{ values, isOpen }"
                                ><span
                                    class="multiselect__single"
                                    v-if="value.length"
                                    v-show="!isOpen"
                                    >{{ values.length }} options selected</span
                                ></template
                            >
                        </multiselect>
                    </div>
                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="numOfPeople"
                            >Max people enrolled</label
                        >
                        <b-form-input
                            v-model="courseData.numOfPeople"
                            type="number"
                            min="0"
                            oninput="this.value = Math.abs(this.value)"
                        ></b-form-input>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="totalTime"
                            >Approx. time to complete</label
                        >
                        <b-form-input
                            v-model="courseData.totalTime"
                            type="number"
                            min="0"
                            oninput="this.value = Math.abs(this.value)"
                        ></b-form-input>
                    </div>

                    <div
                        class="u-display--flex u-display--flex--col u-display--flex--gap--xsml"
                    >
                        <label class="c-input__label" for="difficulty"
                            >Difficulty level</label
                        >
                        <div class="difficulty-b">
                            <b-form-group v-slot="{ ariaDescribedby }">
                                <b-form-radio-group
                                    class="btns"
                                    id="btn-radios"
                                    v-model="courseData.difficulty"
                                    :options="options"
                                    :aria-describedby="ariaDescribedby"
                                    button-variant="outline-primary"
                                    size="lg"
                                    name="radio-btn-outline"
                                    buttons
                                    plain
                                ></b-form-radio-group>
                            </b-form-group>
                        </div>
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
                            @click="validateCourse"
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
import Multiselect from "vue-multiselect";
// import Multiselect from "@vueform/multiselect";

export default {
    components: {
        Multiselect,
    },

    data() {
        return {
            value: [],
            courseData: {
                title: "",
                numOfPeople: "",
                totalTime: "",
                description: "",
                subject: "",
                user_id: this.$store.state.user.id,
                professor_id: "",
                difficulty: "",
                lessons: [],
            },
            selectedLessonsList: [],
            lessonsList: [],
            difficultyList: [],
            isCreating: false,
            token: "",
            professorsList: [],
            subjectsList: [],
            selectedProfessor: {},
            selectedSubject: {},
            selectedLesson: {},
            options: [
                { text: "Easy", value: "Easy" },
                { text: "Medium", value: "Medium" },
                { text: "Hard", value: "Hard" },
            ],
        };
    },

    methods: {
        handleSuccess(res, file) {
            res = `/uploads/${res}`;
            // console.log(res);
            this.courseData.image = res;
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
                    " is incorrect, please select jpg or png",
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File" + file.name + "is too big",
            });
        },

        showMultiSelectedOptions() {
            console.log("Selected list: " + JSON.stringify(this.value));
        },
        printSelected() {
            // Ovo ispisuje samo ID
            console.log("Id: " + JSON.stringify(this.selectedProfessor.id));
        },
        async printSubject() {
            const res = await this.callApi(
                "get",
                "lesson/get-lessons-for-course/" + this.selectedSubject.title
            );

            if (res.status === 200) {
                this.lessonsList = res.data;
            }
        },
        validateCourse() {
            this.saveCourse();
        },
        async saveCourse() {
            this.isCreating = true;
            this.courseData.professor_id = JSON.stringify(
                this.selectedProfessor.id
            );
            this.courseData.subject = this.selectedSubject.title;

            this.courseData.lessons = this.value;

            const res = await this.callApi(
                "post",
                "course/save-course",
                this.courseData
            );

            if (res.status === 201) {
                this.success("Course created successfully");
                this.$router.push({ path: "/courses" });
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
        this.$store.commit("setCurrentPage", "courses");

        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "/get-professors");
        const res2 = await this.callApi("get", "/get-subjects");

        if (res.status === 200) {
            console.log("Professors list: " + res.data);
            this.professorsList = res.data;
        }

        if (res2.status === 200) {
            this.subjectsList = res2.data;
        }
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss"></style>
