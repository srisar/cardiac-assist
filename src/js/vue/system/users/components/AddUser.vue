<template>
    <div class="modal fade" id="modal_add_user">
        <div class="modal-dialog">
            <div class="modal-content">

                <div v-if="user">
                    <div class="modal-header"><h3 class="font-weight-bold">Add a new user - {{ user.display_name }}</h3></div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Display Name</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="user.display_name"
                                   :class="{'is-invalid': !isDisplayNameValid}">
                            <div class="invalid-feedback">Display name is required</div>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="user.username"
                                   :class="{'is-invalid' : !isUsernameValid}">
                            <div class="invalid-feedback">Username is required. At lest 3 letters long</div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password"
                                   class="form-control"
                                   v-model="user.password"
                                   :class="{'is-invalid': !isPasswordValid}">
                            <div class="invalid-feedback">Password must be longer than 5 characters</div>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select v-model="user.role" class="form-control">
                                <option v-for="role in roles" :value="role">{{role}}</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" :disabled="!isFormValid" @click="addUser">Update</button>
                        <button type="button" class="btn badge-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddUser",
        props: ['eventBus'],

        data() {
            return {
                user: {
                    username: "",
                    password: "",
                    role: "USER",
                    display_name: "New User"
                },
                roles: ['ADMIN', 'USER', 'MANAGER'],
            };
        },
        computed: {
            isDisplayNameValid() {
                return this.user.display_name.length !== 0;
            },

            isUsernameValid() {
                return this.user.username.length >= 3;
            },
            isPasswordValid() {
                return this.user.password.length >= 5;
            },
            isFormValid() {
                return this.isDisplayNameValid && this.isUsernameValid && this.isPasswordValid;
            }
        },

        methods: {

            addUser() {
                axios
                    .post(`${getSiteUrl()}/api/users/add`, {
                        username: this.user.username,
                        password: this.user.password,
                        role: this.user.role,
                        display_name: this.user.display_name
                    })
                    .then(res => {

                        $("#modal_add_user").modal("hide");
                        showSuccessToast("User added successfully!");
                        this.emitEventUpdateUsersTable();

                    })
                    .catch(err => {
                        showErrorToast(err.response.data.message);
                    })
            },

            emitEventUpdateUsersTable() {
                this.eventBus.$emit('update-users-table');
            }

        }
    }
</script>

<style scoped>

</style>