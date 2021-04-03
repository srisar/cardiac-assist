<template>

  <div class="">

    <div class="container">
      <div class="row">
        <div class="col">


          <div id="add-echo-values">
            <div class="alert alert-secondary">

              <div class="form-group">
                <label>Value</label>
                <textarea class="form-control" rows="4" v-model="valueToSave.value"></textarea>
              </div>

              <div class="row justify-content-center">
                <div class="col-12 col-md-4">

                  <div class="form-group text-center">
                    <label class="text-center">Type of...</label>
                    <select class="form-control" v-model="valueToSave.type">
                      <option v-for="(item, key) in echoValueTypes" :value="key">{{ item }}</option>
                    </select>
                  </div>

                  <div class="text-center">
                    <button class="btn btn-success" @click="onSave">Save</button>
                  </div>

                </div>
              </div>

            </div>
          </div><!-- add echo values -->


          <div class="card mb-3" v-for="(items, key) in allValues">
            <div class="card-header">{{ echoValueTypes[key] }}</div>
            <div class="card-body">

              <table class="table table-sm table-bordered">
                <thead>
                <tr>
                  <th>Value</th>
                  <th style="width: 100px" class="text-center">Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items">
                  <td>{{ item.value }}</td>
                  <td class="text-center">
                    <button type="button" class="btn btn-warning btn-tiny" @click="onOpenEditModal(item)">
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-tiny" @click="onDelete(item)">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>


        </div><!-- col -->
      </div><!-- row -->
    </div>

    <!-- EDIT Modal -->
    <ModalWindow :visible="editModalVisible" @close="editModalVisible = false">

      <template slot="title">Edit Value</template>

      <div class="form-group">
        <label>Value</label>
        <textarea class="form-control" rows="4" v-model="valueToEdit.value"></textarea>
      </div>

      <div class="text-center">
        <button class="btn btn-success" @click="onUpdate">Update</button>
      </div>

    </ModalWindow>


  </div><!-- template -->

</template>

<script>


import ModalWindow from "../../_common/components/ModalWindow";

export default {
  name: "AllValues",

  components: {ModalWindow},

  data() {
    return {

      editModalVisible: false,

      valueToSave: {
        value: "",
        type: "AORTA"
      },

      valueToEdit: {
        value: "",
        id: undefined,
      }

    }
  },

  computed: {
    echoValueTypes: function () {
      return this.$store.getters.getEchoValueTypes
    },

    allValues: function () {
      return this.$store.getters.getEchoValues
    }

  },

  mounted() {

    this.$store.dispatch('FETCH_ALL')

  },


  methods: {

    onOpenEditModal: function (item) {

      this.valueToEdit.id = item.id
      this.valueToEdit.value = item.value

      this.editModalVisible = true

    },

    onUpdate: function () {

      let item = {
        value: this.valueToEdit.value,
        id: this.valueToEdit.id
      }

      this.$store.dispatch('UPDATE', item)
          .then(() => {
            this.editModalVisible = false
          })

    },

    onSave: function () {

      let item = {
        value: this.valueToSave.value,
        type: this.valueToSave.type
      }

      this.$store.dispatch('SAVE', item)
          .then()

    },

    onDelete: function (item) {

      this.$store.dispatch('DELETE', item.id)
          .then()

    }


  },

}
</script>

<style scoped>

</style>
