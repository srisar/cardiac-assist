<template>

  <div>

    <div id="add-echo-values" class="mb-3">

      <div class="card bg-gradient bg-secondary text-white">
        <div class="card-header d-flex justify-content-between">
          <div>Add Echo Report Values</div>
          <div>
            <button class="btn btn-primary btn-tiny" @click="addModalVisible = true">Add new value</button>
          </div>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" v-model="valueToAdd.type">
                  <option v-for="(item, key) in echoValueTypes" :value="key">{{ item }}</option>
                </select>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label>Values</label>
            <select class="form-control" v-model="valueToAdd.echoValue">
              <option selected disabled :value="null">Choose a value</option>
              <option v-for="(item, key) in selectedEchoValues" :value="item">{{ item.value }}</option>
            </select>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="onAdd" :disabled="!validated">Add</button>
          </div>

        </div><!-- card-body -->
      </div><!-- card -->


    </div>

    <hr>

    <div class="text-center">
      <p class="lead font-weight-bold">Echocardiography Report Details</p>
    </div>

    <div class="mb-3 p-1" v-for="(items, key) in visitEchoValues">
      <hr class="m-0">
      <div class="lead font-weight-bold mb-2">{{ echoValueTypes[key] }}</div>
      <div class="">

        <table class="table table-sm table-bordered table-hover">
          <tbody>
          <tr v-for="item in items">
            <td>{{ item.echoValue.value }}</td>
            <td class="text-center" style="width: 40px">
              <button type="button" class="btn btn-danger btn-tiny" @click="onDelete(item)">
                <i class="bi bi-trash-fill"></i>
              </button>
            </td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>

    <!-- MODAL: Add new echo value -->

    <!-- EDIT Modal -->
    <ModalWindow :visible="addModalVisible" @close="addModalVisible = false">

      <template slot="title">Add new echo report value</template>

      <div class="form-group">
        <label>Value</label>
        <textarea class="form-control" rows="4" v-model="commonEchoValueToAdd.value"></textarea>
      </div>

      <div class="row justify-content-center">
        <div class="col-12 col-md-4">

          <div class="form-group text-center">
            <label class="text-center">Type of...</label>
            <select class="form-control" v-model="commonEchoValueToAdd.type">
              <option v-for="(item, key) in echoValueTypes" :value="key">{{ item }}</option>
            </select>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="onSaveNewEchoValue">Save</button>
          </div>

        </div>
      </div>

    </ModalWindow>


  </div><!-- template -->

</template>

<script>


import ModalWindow from "../../../_common/components/ModalWindow";

export default {
  name: "VisitEchoReports",
  components: {ModalWindow},
  data() {
    return {

      echoValueTypes: {
        'AORTA': 'Aorta',
        'AORTIC_VALVE': 'Aortic Valve',
        'DOPPLER': 'Doppler',
        'LEFT_ATRIUM': 'Left Atrium',
        'MITRAL_VALVE': 'Mitral Valve',
        'PERICARDIUM': 'Pericardium',
        'PULMONIC_VALVE': 'Pulmonic Valve',
        'RIGHT_ATRIUM': 'Right Atrium',
        'RIGHT_VENTRICLE': 'Right Ventricle',
        'TRICUSPID': 'Tricuspid',
      },

      valueToAdd: {
        echoValue: null,
        type: "AORTA"
      },

      addModalVisible: false,

      commonEchoValueToAdd: {
        value: '',
        type: 'AORTA'
      }

    }
  },

  computed: {

    allEchoValues: function () {
      return this.$store.getters.getEchoValues
    },

    visitEchoValues: function () {
      return this.$store.getters.getVisitEchoValues
    },

    selectedEchoValues: function () {
      return this.allEchoValues[this.valueToAdd.type]
    },

    visitId: function () {
      return this.$store.getters.getVisitId
    },

    validated: function () {
      return this.valueToAdd.echoValue !== null;
    }

  },

  watch: {
    selectedEchoValues(newValue, oldValue) {
      this.valueToAdd.echoValue = null
    }
  },

  mounted() {

    this.$store.dispatch('FETCH_ALL_ECHO_VALUES')
        .then()

    this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
        .then()

  },

  methods: {

    onAdd: function () {

      let item = {
        visit_id: this.visitId,
        echo_value_id: this.valueToAdd.echoValue.id,
        type: this.valueToAdd.type,
      }

      this.$store.dispatch('ADD_VISIT_ECHO_VALUE', item)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
                .then()
          })
    },


    onDelete: function (item) {

      this.$store.dispatch('DELETE_VISIT_ECHO_VALUE', item.id)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
                .then()
          })

    },

    onSaveNewEchoValue: function () {

      let item = {
        value: this.commonEchoValueToAdd.value,
        type: this.commonEchoValueToAdd.type
      }

      this.$store.dispatch('SAVE_NEW_ECHO_VALUE', item)
          .then(() => {

            this.commonEchoValueToAdd.value = ''

            this.addModalVisible = false

          })

    },


  },
}
</script>

<style>

.report-section {

}

.report-section__title {
  font-size: 1em;
  font-weight: bold;
}

</style>
