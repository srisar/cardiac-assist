<template>
    <div>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">

                    <div class="card">
                        <div class="card-header">
                            <div class="align-content-center">Manage users</div>

                        </div>
                        <div class="card-body">

                            <div class="mb-3 text-right">
                                <button class="btn btn-primary btn-sm" @click="">Add new user</button>
                            </div>

                            <list-users @user-selected="setSelectedUser" :event-bus="eventBus"></list-users>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <edit-user v-bind:user="selectedUser" @user-updated="updateUsersList" :event-bus="eventBus"></edit-user>

    </div>
</template>

<script>

    import ListUsers from "./components/ListUsers";
    import EditUser from "./components/EditUser";

    export default {
        name: "ManageUserApp",
        components: {
            ListUsers,
            EditUser
        },
        data() {
            return {
                selectedUser: null,
                eventBus: new Vue({}),
            };
        },
        methods: {

            setSelectedUser(selectedUser) {
                this.selectedUser = _.cloneDeep(selectedUser);
                this.selectedUser.password_string = "";
                this.selectedUser.conform_password_string = "";
            },

            updateUsersList() {

            }

        },
    }
</script>

<style scoped>

</style>