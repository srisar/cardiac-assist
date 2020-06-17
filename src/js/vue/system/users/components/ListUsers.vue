<template>
    <div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Username</th>
                <th>Display Name</th>
                <th>Role</th>
                <th class="text-center">Edit</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td>{{ user.username }}</td>
                <td>{{ user.display_name }}</td>
                <td>{{ user.role }}</td>
                <td class="text-center">
                    <button class="btn btn-dark btn-sm" @click="openEditUserModal(user)"><i class="fas fa-pencil"></i></button>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "ListUsers",
        props: {
            eventBus: {}
        },

        data() {
            return {
                users: null,
            };
        },

        created() {
            this.fetchUsers();
        },

        mounted() {
            this.eventBus.$on('update-users-table', this.fetchUsers);
        },

        methods: {

            fetchUsers() {

                axios
                    .get(`${getSiteUrl()}/api/users/all`)
                    .then(response => {
                        return response.data;
                    })
                    .then(data => {
                        this.users = data.users;
                    })
                    .catch(error => {
                        showErrorToast(error.response.data.message);
                    })

            },

            openEditUserModal(user) {
                $("#modal_edit_user").modal("show");
                this.$emit('user-selected', user)
            }

        }
    }
</script>

<style scoped>


</style>