<template>

  <div>

    <div class="container">
      <div class="row justify-content-center mb-4">

        <div class="col-12 col-md-6 mb-4">

          <div class="card shadow shadow-sm">

            <div class="card-header">Add New User</div>
            <div class="card-body">

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label>Display name</label>
                    <input type="text" v-model="userToAdd.display_name" class="form-control">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" v-model="userToAdd.role">
                      <option v-for="item in roles" :value="item.key">{{ item.value }}</option>
                    </select>
                  </div>
                </div>
              </div><!-- row -->

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" v-model="userToAdd.new_password" class="form-control">
                  </div>

                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Confirm new password</label>
                    <input type="password" v-model="userToAdd.confirm_new_password" class="form-control">
                  </div>

                </div>
              </div><!-- row -->


              <div class="text-right">
                <button class="btn btn-primary" :disabled="! passwordValidated">Save</button>
              </div>

            </div><!-- card-body -->
          </div>
        </div>


      </div><!-- row -->

      <div class="row justify-content-center">

        <div class="col-12 col-md-6">
          <div class="card shadow shadow-sm">
            <div class="card-header">
              Manage Users
            </div>
            <div class="card-body">

              <table class="table table-bordered table-sm">
                <thead>
                <tr>
                  <th>Display Name</th>
                  <th>Username</th>
                  <th>Role</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="(item, index) in users">
                  <td><a href="#" @click="openEditModal(item)">{{ item.display_name }}</a></td>
                  <td>{{ item.username }}</td>
                  <td>{{ item.role }}</td>
                </tr>

                </tbody>
              </table>

            </div>
          </div><!-- card -->
        </div><!-- col -->

      </div>

    </div>

    <EditUser :user="selectedUser" @close="closedEditUserModal" @user-updated="onUserUpdated"></EditUser>

  </div><!-- template -->

</template>

<script>

import EditUser from "./EditUser";

export default {
  name: "ManageUsers",
  components: {EditUser,},
  props: [],


  data() {
    return {
      users: [],
      selectedUser: undefined,

      userToAdd: {
        username: "",
        display_name: "",
        role: "ADMIN",
        new_password: "",
        confirm_new_password: "",
      },

      roles: [
        {key: 'USER', value: 'User'},
        {key: 'MANAGER', value: 'Manager'},
        {key: 'ADMIN', value: 'Administrator'},
      ]

    }
  },


  computed: {

    passwordValidated: function () {
      if (this.userToAdd.new_password === "") return false;
      return this.userToAdd.new_password === this.userToAdd.confirm_new_password;
    }


  },

  mounted() {

    this._fetchUsers();

  },


  methods: {

    /**
     * Fetch all users
     * @private
     */
    _fetchUsers: function () {

      $.get(`${getSiteURL()}/api/get/users.php`)
          .done(response => {
            this.users = response.data;
          })
          .fail(error => {
            console.log('Failed to fetch users');
          });

    },

    /**
     * Open the edit modal window with given user
     * @param user
     */
    openEditModal: function (user) {
      this.selectedUser = user;
    },

    closedEditUserModal: function () {
      this.selectedUser = undefined;
    },

    onUserUpdated: function () {
      this._fetchUsers();
    },

    /**
     *
     */
    saveNewUser: function () {


    },


  },

}
</script>

<style scoped>

</style>
