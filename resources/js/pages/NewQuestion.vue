<template>
    <div>
        <Nav />
        <b-container>
            <b-row>
                <b-col class="new-right" cols="7">
                    <label for="title" style="color: #f9690e"
                        ><b>Question text</b></label
                    >
                    <b-form-input
                        v-model="questionData.text"
                        class="Question"
                        type="text"
                    ></b-form-input>

                    <label for="title" style="color: #f9690e"
                        ><b>Answer A:</b></label
                    >
                    <b-form-input
                        v-model="questionData.A"
                        class="Question"
                        type="text"
                    ></b-form-input>

                    <label for="title" style="color: #f9690e"
                        ><b>Answer B:</b></label
                    >
                    <b-form-input
                        v-model="questionData.B"
                        class="Question"
                        type="text"
                    ></b-form-input>

                    <label for="title" style="color: #f9690e"
                        ><b>Answer C:</b></label
                    >
                    <b-form-input
                        v-model="questionData.C"
                        class="Question"
                        type="text"
                    ></b-form-input>

                    <label for="title" style="color: #f9690e"
                        ><b>Answer D:</b></label
                    >
                    <b-form-input
                        v-model="questionData.D"
                        class="Question"
                        type="text"
                    ></b-form-input>

                    <label for="multi-lesson" style="color: #f9690e"
                        ><b>Correct answer</b></label
                    >

                    <multiselect
                        v-model="value"
                        :options="answersList"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        placeholder="Pick some"
                        label="title" track-by="title"
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
                    

                    <div class="buttons">
                        <router-link to="/">
                            <Button class="login-btn">Cancel</Button>
                        </router-link>
                        <Button
                            @click="validateQuestion"
                            class="start-btn"
                            :loading="isCreating"
                            :disabled="isCreating"
                        >
                            Save
                            
                        </Button>
                    </div>
                </b-col>
            </b-row>
            <div class="space"></div>
        </b-container>
    </div>
</template>

<script>
import Nav from "../components/Nav";
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },

    data() {
        return {
            value: [],
            questionData: {
                text: "",
                A: "",
                B: "",
                C: "",
                D: "",
                answersList: [],
            },
            answersList: [{'A':this.questionData.A, 'B':this.questionData.B, 'C':this.questionData.C, 'D':this.questionData.D}],
            isCreating: false,
            token: "",
        };
    },

    methods: {
        showMultiSelectedOptions(){
            console.log("Selected list: " + JSON.stringify(this.value));
        },
        validateQuestion() {
            this.saveQuestion();
        },
        async saveQuestion() {
            this.isCreating = true;
            this.questionData.answers = this.value;

            const res = await this.callApi(
                "post",
                "question/save-question",
                this.questionData
            );

            if (res.status === 201) {
                console.log(res);
                this.success("question created successfully, redirecting...");
                this.$router.push({ path: "/questions" });
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
        this.token = window.Laravel.csrfToken;
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss">
.new-left {
    background-color: #fff9f6;

    button {
        width: 204px;
        height: 64px;
        box-shadow: 0px 20px 50px 0px rgba(249, 105, 14, 0.3);
        background-color: #f9690e;
        box-shadow: rgba(249, 105, 14, 0.3) 0px 30px 100px -20px,
            rgba(249, 105, 14, 0.3) 0px 30px 60px -30px;
        transition: all 0.3s ease-in-out;
        color: white;
        font-size: 16px;
        font-weight: 700;
        border-radius: 8px;
        &:hover {
            color: white;
            background-color: rgba(249, 105, 14, 0.9);
            box-shadow: rgba(249, 105, 14, 0.7) 0px 20px 100px -20px,
                rgba(249, 105, 14, 0.7) 0px 20px 60px -30px;
            border-color: #f9690e;
        }
    }
    .question-img {
        object-fit: cover;
        max-width: 550px;
        max-height: 700px;
        cursor: pointer;
    }
    .ivu-upload {
        display: flex;
        flex-direction: column;
        min-height: 700px;
        justify-content: center;
        align-items: center;
    }

    .demo-upload-list-cover i {
        width: 30px;
        height: 30px;
        color: red;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
}
.new-right {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    .form-control {
        max-width: 350px;
        outline: none;
        border-width: 0 0 1px;
        border-radius: 0;
        border-color: #a5a5a54d;
        background-color: transparent;
        &:hover,
        &:focus {
            outline: none;
            box-shadow: none;
            border-width: 0 0 1px;
            transition: all 0.2s ease-in;
            border-color: #f9690e;
        }
    }
    .lesson,
    .instruction {
        .remove {
            height: 30px;
            width: 100px;
            border-color: #3333334d;
            &:hover {
                color: #f9690e;
            }
            &:focus {
                color: white;
                background-color: #f9690e;
                border-color: #f9690e;
            }
        }
    }
    .instruction {
        .remove {
            margin-left: 150px;
            margin-top: 5px;
        }
    }

    .difficulty-b {
        label {
            border-color: transparent;

            &:hover {
                color: #f9690e;
            }
            &:focus {
                color: white;
                background-color: #f9690e;
                border-color: #f9690e;
            }
        }
    }
    .btns {
        border-radius: 20px;

        background-color: #f9690e1a;
        label {
            color: #2c2f31;
            font-size: 16px;
            text-transform: capitalize;
            font-weight: 600;
            &:hover {
                color: white;
                background-color: #f9690e;
            }
        }
        input {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .active,
        .focus {
            background-color: #f9690e;
            color: white;
        }
    }

    .buttons {
        button {
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
        }
        .login-btn {
            width: 168px;
            height: 64px;
            color: #333333e0;
            border: 1px solid #f9690e;
            margin-right: 16px;
            transition: all 0.3s ease-in-out;

            &:hover {
                border: 1px solid rgba(249, 105, 14, 0.4);
            }
        }
        .start-btn {
            width: 232px;
            height: 74px;
            box-shadow: 0px 20px 50px 0px rgba(249, 105, 14, 0.3);
            background-color: #f9690e;
            box-shadow: rgba(249, 105, 14, 0.3) 0px 30px 100px -20px,
                rgba(249, 105, 14, 0.3) 0px 30px 60px -30px;
            transition: all 0.3s ease-in-out;
            color: white;
            &:hover {
                background-color: rgba(249, 105, 14, 0.9);
                box-shadow: rgba(249, 105, 14, 0.7) 0px 20px 100px -20px,
                    rgba(249, 105, 14, 0.7) 0px 20px 60px -30px;
                border-color: #f9690e;
            }
        }
    }

    .people-minutes,
    .lesson {
        input {
            width: 100px;
        }
    }

    svg {
        cursor: pointer;
    }
    .sup {
        width: 100px;
        height: 5px;
        background: #f9690e;
    }
}

.space {
    height: 100px;
}
</style>
