const app = new Vue({
    el: "#app",

    data: {
        login: {
            success: false
        },

        username: "",
        password: "",

        forms: {
            invalidUsername: false,
            invalidPassword: false
        }
    },
    watch: {
        username: function (newValue) {
            this.forms.invalidUsername = newValue.length === 0;
        },
        password: function (newValue) {
            this.forms.invalidPassword = newValue.length === 0;
        }
    },
    methods: {

        tryLogin() {


            if (this.username.length === 0 || this.password.length === 0) {
                this.forms.invalidUsername = true;
                this.forms.invalidPassword = true;
                return false;
            }


            axios.post(`${getSiteUrl()}/api/auth/process-login`, {
                username: this.username,
                password: this.password
            }).then(response => {
                return response.data;
            }).then(data => {

                redirect(`${getSiteUrl()}`);

            }).catch(error => {
                let result = error.response.data.message;
                showErrorToast(result);
            });

        },

        redirect() {
            if (this.login.success) {
                redirect(`${getSiteUrl()}`);
            }
        },


    }
});