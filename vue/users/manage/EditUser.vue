<template>

  <div>


    <ModalWindow ref="modal_edit_user" @modal-hiding="close">
      <template v-slot:title v-if="user">Edit - {{ user.display_name }}</template>
      <slot>
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

        <div class="text-center mt-3">
          <button type="button" class="btn btn-primary" :disabled="!isFormValid" @click="onClickUpdateUser">Save changes</button>
        </div>

      </slot>

    </ModalWindow>

  </div>

</template>

<script>
import ModalWindow from "../../_common/components/ModalWindow";

export default {
  name      : "EditUser",
  components: { ModalWindow },
  props     : ['user',],

  data() {
    return {
      selectedUser: {
        id                  : "",
        username            : "",
        display_name        : "",
        role                : "",
        new_password        : "",
        confirm_new_password: "",
      },

      roles: [
        { key: 'USER', value: 'User' },
        { key: 'MANAGER', value: 'Manager' },
        { key: 'ADMIN', value: 'Administrator' },
      ],

      updatePassword: false,

    }
  },

  watch: {

    /*
    * Watch for user prop: if set, then display the modal window
    * */
    user: function (value) {
      if ( value !== undefined ) {

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
      if ( this.selectedUser.new_password === "" ) return false;
      return this.selectedUser.new_password === this.selectedUser.confirm_new_password;
    },

    isFormValid: function () {

      if ( this.updatePassword ) {
        return this.passwordValidated && this.selectedUser.display_name !== "";
      }

      return this.selectedUser.display_name !== "";

    },

  },

  mounted() {
  },

  methods: {

    /*
    * Show modal window
    * */
    showModal() {
      this.$refs.modal_edit_user.show();
    },

    onClickUpdateUser: function () {

      $.post(`${getSiteURL()}/api/update/user.php`, {
        id             : this.selectedUser.id,
        display_name   : this.selectedUser.display_name,
        password       : this.selectedUser.new_password,
        role           : this.selectedUser.role,
        change_password: this.updatePassword
      }).done(r => {

        this.$refs.modal_edit_user.hide();
        this.$emit('user-updated');

      }).fail(e => {

      });

    },

    close: function () {
      this.$emit('close');
    }

  },
}
</script>

<style scoped>

</style>
