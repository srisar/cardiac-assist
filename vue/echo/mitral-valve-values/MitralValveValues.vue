<template>

  <div>

    <div class="container">
      <div class="row">
        <div class="col">

          <div class="card shadow shadow-sm">
            <div class="card-header">Echo Mitral Valve Values</div>
            <div class="card-body">


              <div class="">
                <div class="form-group">
                  <label>Value</label>
                  <textarea rows="3" class="form-control" v-model.trim="mitralValveValueToAdd.value"></textarea>
                </div>

                <div class="text-center">
                  <button class="btn btn-success" @click="save" :disabled="isEmptyValue(mitralValveValueToAdd.value)">Save</button>
                </div>
              </div>


              <div class="my-3">
                <hr>
                <table class="table table-bordered table-sm" v-if="! isEmptyList">
                  <tr v-for="(item) in mitralValveValues">
                    <td>{{ item.value }}</td>
                    <td style="width: 100px" class="text-center">
                      <button class="btn btn-tiny btn-warning" @click="openEditModal(item)">Edit</button>
                    </td>
                  </tr>
                </table>

                <div class="text-center" v-else>No values in the database, please add something.</div>

              </div>


            </div><!-- card-body -->
          </div><!-- card -->

        </div><!-- col -->
      </div><!-- row -->
    </div>

    <ModalWindow id="edit-window" :visible="modalEditWindowVisible" @close="closeEditModal">
      <template v-slot:title>Edit Item</template>

      <div>
        <div class="">
          <div class="form-group">
            <label>Value</label>
            <textarea rows="3" class="form-control" v-model.trim="mitralValveValueToEdit.value"></textarea>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="update" :disabled="isEmptyValue(mitralValveValueToEdit.value)">update</button>
          </div>
        </div>
      </div>

    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";

const _ = require('lodash')

export default {
  name: "MitralValveValues",

  components: { ModalWindow },

  data() {
    return {

      modalEditWindowVisible: false,

      mitralValveValueToAdd: {
        value: "",
      },

      mitralValveValueToEdit: {
        id   : undefined,
        value: "",
      },

      mitralValveValues: [],

    }
  }, /* DATA */

  computed: {

    isEmptyList: function () {
      return _.isEmpty(this.mitralValveValues)
    },

  }, /* COMPUTED */

  mounted() {

    this.fetchAll()

  }, /* MOUNTED */


  methods: {

    isEmptyValue: function (value) {
      return _.isEmpty(value)
    },

    fetchAll: function () {
      $.get(`${getSiteURL()}/api/get/echo-mitral-valve-values.php`)
          .done(response => {
            this.mitralValveValues = response.data
          })
          .fail(e => { console.log(e) })
    },

    save: function () {

      const param = {
        value: this.mitralValveValueToAdd.value
      }

      $.post(`${getSiteURL()}/api/save/echo-mitral-valve-value.php`, param)
          .done(() => {
            // fetch everything again
            this.fetchAll()
          })
          .fail(e => { console.log(e) })

    },

    openEditModal: function (item) {
      this.mitralValveValueToEdit = _.cloneDeep(item)
      this.modalEditWindowVisible = true
    },

    closeEditModal: function () {
      this.modalEditWindowVisible = false
    },

    update: function () {
      const param = {
        id   : this.mitralValveValueToEdit.id,
        value: this.mitralValveValueToEdit.value,
      }

      $.post(`${getSiteURL()}/api/update/echo-mitral-valve-value.php`, param)
          .done(() => {
            // fetch everything again
            this.fetchAll()
          })
          .fail(e => { console.log(e) })
    },

  }, /* METHODS */


}
</script>

<style scoped>

</style>
