<template>

  <div>


    <!-- Modal -->
    <div class="modal fade" id="modal-edit-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-if="user">Edit User: {{ user.display_name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">


            <div class="form-row">

              <div class="col">
                <div class="form-group">
                  <label>Display name</label>
                  <input type="text" v-model="selectedUser.display_name" class="form-control">
                </div>
              </div><!-- col -->

              <div class="col">
                <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" v-model="selectedUser.role">
                    <option v-for="item in roles" :value="item.key">{{ item.value }}</option>
                  </select>
                </div>
              </div><!-- col -->

            </div><!-- row -->

            <hr>
            <div class="form-row">
              <div class="col mb-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="chk-change-password" v-model="updatePassword">
                  <label for="chk-change-password" class="custom-control-label">Update password</label>
                </div>

              </div>
            </div>

            <div v-if="updatePassword" class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" v-model="selectedUser.new_password" class="form-control">
                </div>
              </div><!-- col -->

              <div class="col">
                <div class="form-group">
                  <label>Confirm new password</label>
                  <input type="password" v-model="selectedUser.confirm_new_password" class="form-control">
                </div>
              </div><!-- col -->
            </div><!-- row -->


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" :disabled="!isFormValid" @click="onClickUpdateUser">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  </div>

</template>

<script>
export default {
  name: "EditUser",
  props: ['user',],

  data() {
    return {
      selectedUser: {
        id: "",
        username: "",
        display_name: "",
        role: "",
        new_password: "",
        confirm_new_password: "",
      },

      roles: [
        {key: 'USER', value: 'User'},
        {key: 'MANAGER', value: 'Manager'},
        {key: 'ADMIN', value: 'Administrator'},
      ],

      updatePassword: false,

    }
  },

  watch: {

    /*
    * Watch for user prop: if set, then display the moral window
    * */
    user: function (value) {
      if (value !== undefined) {

        this.selectedUser.id = value.id;
        this.selectedUser.username = value.username;
        this.selectedUser.display_name = value.display_name;
        this.selectedUser.role = value.role;
        this.selectedUser.new_password = "";
        this.selectedUser.confirm_new_password = "";

        this.showModal();
      }
    },

  },

  computed: {
    //

    passwordValidated: function () {
      if (this.selectedUser.new_password === "") return false;
      return this.selectedUser.new_password === this.selectedUser.confirm_new_password;
    },

    isFormValid: function () {

      if (this.updatePassword) {
        return this.passwordValidated && this.selectedUser.display_name !== "";
      }

      return this.selectedUser.display_name !== "";

    },

  },

  mounted() {

    /*
    * Empty selected user when modal is closed.
    * */
    $("#modal-edit-user").on('hidden.bs.modal', (e) => {
      this.selectedUser = {
        id: "",
        username: "",
        display_name: "",
        role: "",
        password: ""
      };

      this.$emit('close');
    });

  },

  methods: {

    /*
    * Show modal window
    * */
    showModal() {
      $("#modal-edit-user").modal('show');
    },

    onClickUpdateUser: function () {

      $.post(`${getSiteURL()}/api/update/user.php`, {
        id: this.selectedUser.id,
        display_name: this.selectedUser.display_name,
        password: this.selectedUser.new_password,
        role: this.selectedUser.role,
        change_password: this.updatePassword
      }).done(r => {

        console.log(r);

      }).fail(e => {

      });

    },


  },
}
</script>

<style scoped>

</style>
