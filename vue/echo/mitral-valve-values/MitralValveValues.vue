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

            <div class="my-2">
              {{ messages.updateMessage }}
            </div>

          </div>
        </div>
      </div>

    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";
import apiMixin from "./api_mixins"

const _ = require('lodash')

export default {
  name  : "MitralValveValues",
  mixins: [apiMixin],

  components: { ModalWindow },

  data() {
    return {
      modalEditWindowVisible: false,


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


    openEditModal: function (item) {
      this.mitralValveValueToEdit = _.cloneDeep(item)
      this.modalEditWindowVisible = true
    },

    closeEditModal: function () {
      this.modalEditWindowVisible = false
      this.messages.updateMessage = ''
    },


  }, /* METHODS */


}
</script>

<style scoped>

</style>
