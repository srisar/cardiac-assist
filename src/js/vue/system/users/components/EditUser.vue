<template>

    <div class="modal fade" id="modal_edit_user">
        <div class="modal-dialog">
            <div class="modal-content">

                <div v-if="user">
                    <div class="modal-header"><h3 class="font-weight-bold">Edit User - {{ user.display_name }}</h3></div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Display Name</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="user.display_name"
                                   :class="{'is-invalid': !isDisplayNameValid}">
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="user.username"
                                   :class="{'is-invalid' : !isUsernameValid}">
                        </div>

                        <div class="alert alert-danger">

                            <div class="form-group form-check">
                                <input type="checkbox" id="change-password" class="form-check-input" v-model="changePassword">
                                <label for="change-password"> Change password</label>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="user.password_string"
                                               :disabled="!changePassword">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="user.confirm_password_string"
                                               :disabled="!changePassword">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select v-model="user.role" class="form-control">
                                <option v-for="role in roles" :value="role">{{role}}</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" :disabled="!isFormValid" @click="updateUser">Update</button>
                        <button type="button" class="btn badge-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EditUser",

        props: {
            user: {
                type: Object,
                default() {
                    return {
                        id: null,
                        username: null,
                        password_string: null,
                        confirm_password_string: null,
                        role: null
                    };
                }
            },
            eventBus: {}
        },

        data() {
            return {
                changePassword: false,
                roles: ["USER", "ADMIN", "MANAGER"]
            };
        },

        computed: {

            isUsernameValid() {
                return this.user.username !== "";
            },

            isDisplayNameValid() {
                return this.user.display_name !== "";
            },

            isFormValid() {
                return this.isUsernameValid && this.isDisplayNameValid && this.isPasswordValid;

            },
            isPasswordValid() {

                if (this.changePassword) {
                    if (this.user.password_string.length === 0 || this.user.confirm_password_string.length === 0) {
                        return false;
                    } else {
                        return true;
                    }
                }
                return true;
            }
        },

        methods: {

            updateUser() {

                axios
                    .post(`${getSiteUrl()}/api/users/edit`, {
                        id: this.user.id,
                        username: this.user.username,
                        display_name: this.user.display_name,
                        password: this.user.password_string,
                        role: this.user.role
                    })
                    .then(res => {

                        showSuccessToast('User details updated');
                        $("#modal_edit_user").modal("hide");

                        this.emitEventUpdateUsersTable();

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    });

            },

            emitEventUpdateUsersTable(){
                this.eventBus.$emit('update-users-table');
            }

        }
    }
</script>

<style scoped>

</style>