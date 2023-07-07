import axios from "axios";

export default {
    data() {
        return {};
    },
    methods: {
        async callApi(method, url, data) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: data,
                });
            } catch (error) {
                return error.response;
            }
        },
        info(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc,
            });
        },
        success(desc, title = "Great") {
            this.$Notice.success({
                title: title,
                desc: desc,
            });
        },
        warning(desc, title = "Ooops") {
            this.$Notice.warning({
                title: title,
                desc: desc,
            });
        },
        error(desc, title = "Wrong") {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
        swr(desc = "Something went wrong! Please try again", title = "Oops") {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
    },
};
