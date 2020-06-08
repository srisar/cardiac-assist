$(function () {
    processLogin();
});

function processLogin() {

    let fields = {
        'username': $("#field_username"),
        'password': $("#field_password")
    }

    $("#btn_login").on("click", function () {

        axios.post(`${getSiteUrl()}/api/auth/process-login`, {
            'username': fields.username.val(),
            'password': fields.password.val()
        })
            .then(function (response) {

                redirect(`${getSiteUrl()}`);

            })
            .catch(function (error) {

                showErrorToast(error.response.data.data);

            });

    });

}