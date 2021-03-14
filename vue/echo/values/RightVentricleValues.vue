<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Right Ventricle Remarks</div>
      <div class="card-body">


        <div class="">
          <div class="form-group">
            <textarea rows="3" class="form-control" v-model.trim="toAdd.value"></textarea>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="onSave" :disabled="isEmptyValue(toAdd.value)">Save</button>
          </div>
        </div>


        <div class="my-3">
          <hr>
          <table class="table table-bordered table-sm" v-if="! isEmptyList">
            <tr v-for="(item) in values">
              <td>{{ item.value }}</td>
              <td style="width: 100px" class="text-center">
                <button class="btn btn-tiny btn-warning" @click="openEditModal(item)">Edit</button>

                <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Delete</button>

              </td>
            </tr>
          </table>

          <div class="text-center" v-else>No values in the database, please add something.</div>

        </div>


      </div><!-- card-body -->
    </div><!-- card -->


    <ModalWindow id="edit-window" :visible="modalEditWindowVisible" @close="closeEditModal">
      <template v-slot:title>Edit Item</template>

      <div>
        <div class="">
          <div class="form-group">
            <label>Value</label>
            <textarea rows="3" class="form-control" v-model.trim="toEdit.value"></textarea>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="onUpdate" :disabled="isEmptyValue(toEdit.value)">update</button>

          </div>
        </div>
      </div>

    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";
import mixins from "./common.mixin"

const _ = require('lodash')

export default {
  name      : "RightVentricleValues",
  mixins    : [mixins],
  components: { ModalWindow },

  mounted() {

    this.fetchAll()

  }, /* MOUNTED */


  methods: {

    /*
    * Fetch all values
    * */
    fetchAll: function () {
      $.get(`${getSiteURL()}/api/get/echo/echo-right-ventricle-values.php`)
          .done(response => {
            this.values = response.data
          })
          .fail(e => { console.log(e) })
    },

    /*
    * Save new value
    * */
    onSave: function () {

      const param = {
        value: this.toAdd.value
      }

      $.post(`${getSiteURL()}/api/save/echo/echo-right-ventricle-value.php`, param)
          .done(() => {
            // fetch everything again
            this.fetchAll()
          })
          .fail(e => { console.log(e) })

    },

    /*
    * Updates the values
    * */
    onUpdate: function () {
      const param = {
        id   : this.toEdit.id,
        value: this.toEdit.value,
      }

      $.post(`${getSiteURL()}/api/update/echo/echo-right-ventricle-value.php`, param)
          .done(() => {

            // fetch everything again
            this.fetchAll()
            this.closeEditModal()
          })
          .fail(e => {
            bootbox.alert(`<p class="lead text-danger">Updated failed</p>`)
            console.log(e)
          })
    },

    /*
    * Delete selected value
    * */
    onDelete: function (item) {

      const message = `<p class="lead">Do you want to delete?</p>` +
                      `<p>This will delete this from all associated visit data.</p>`

      bootbox.confirm(message, result => {
        if ( result ) {

          const param = {
            id: item.id,
          }

          $.post(`${getSiteURL()}/api/delete/echo/echo-right-ventricle-value.php`, param)
              .done(() => {
                // fetch everything again
                this.fetchAll()
              })
              .fail(e => {
                console.log(e)
              })
        }
      })
    }

  }, /* METHODS */


}
</script>

<style scoped>

</style>
