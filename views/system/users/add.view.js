$(function () {
    addUser();
});

function addUser() {


    $("#btn_add_user").on("click", function () {

        resetInputFields($("#form_add_user"));


        let fields = {
            'display_name': $("#field_display_name"),
            'username': $("#field_username"),
            'password': $("#field_password"),
            'role': $("#dropdown_user_role"),
        };

        let validated = true;

        if (fields.display_name.val().toString().trim() === "") {
            validated = false;
            makeInputFieldInvalid(fields.display_name);
        }
        if (fields.username.val().toString().trim() === "") {
            validated = false;
            makeInputFieldInvalid(fields.username);
        }
        if (fields.password.val().toString() === "") {
            validated = false;
            makeInputFieldInvalid(fields.password);
        }


        if (!validated) return false;

        axios.post(`${getSiteUrl()}/api/users/process-add`, {
            'display_name': fields.display_name.val(),
            'username': fields.username.val(),
            'password': fields.password.val(),
            'role': fields.role.val(),
        })
            .then(function (response) {

                redirect(`${getSiteUrl()}/users`);

            })
            .catch(function (error) {
                showErrorToast(error.response.data.data);
            });

    });


}