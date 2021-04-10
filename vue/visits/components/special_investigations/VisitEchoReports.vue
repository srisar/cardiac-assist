<template>

  <div>

    <!-- card: add echo report remarks -->
    <div id="add-echo-values" class="mb-3">


      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div>Add Echo Report Remarks</div>
          <div>
            <button class="btn btn-primary btn-tiny" @click="addModalVisible=true">Add new value</button>
          </div>
        </div>
        <div class="card-body gray-bg">

          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" v-model="remarkToAdd.type">
                  <option v-for="(item, key) in echoRemarksTypes" :value="key">{{ item }}</option>
                </select>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label>Values</label>
            <select class="form-control" v-model="remarkToAdd.echoValue">
              <option selected disabled :value="null">Choose a value</option>
              <option v-for="(item) in selectedEchoRemarks" :value="item">{{ item.value }}</option>
            </select>
          </div>

          <div class="text-center">
            <button class="btn btn-success" @click="onAdd" :disabled="!validated">Add</button>
          </div>

        </div><!-- card-body -->
      </div><!-- card -->
    </div>
    <!-- end: card: echo report remarks -->

    <hr>

    <!-- visit echo remarks -->
    <div id="visit-echo-remarks">
      <div class="text-center">
        <p class="lead font-weight-bold">Echocardiography Remarks</p>
      </div>

      <div v-for="(items, key) in visitEchoRemarks">

        <div v-if="items.length > 0" class="border mb-3 p-1">

          <div class="font-weight-bold mb-2">{{ echoRemarksTypes[key] }}</div>

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

    </div>
    <!-- end: visit echo remarks -->

    <!-- MODAL: Add new echo value -->

    <!-- EDIT Modal -->
    <ModalWindow :visible="addModalVisible" @close="addModalVisible = false">

      <template slot="title">Add new echo report remark</template>

      <div class="form-group">
        <label>Value</label>
        <textarea class="form-control" rows="4" v-model="commonEchoRemarkToAdd.value"></textarea>
      </div>

      <div class="row justify-content-center">
        <div class="col-12 col-md-4">

          <div class="form-group text-center">
            <label class="text-center">Type of...</label>
            <select class="form-control" v-model="commonEchoRemarkToAdd.type">
              <option v-for="(item, key) in echoRemarksTypes" :value="key">{{ item }}</option>
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

      echoRemarksTypes: {
        'LEFT_VENTRICLE': 'Left Ventricle',
        'LEFT_ATRIUM': 'Left Atrium',
        'MITRAL_VALVE': 'Mitral Valve',
        'AORTIC_VALVE': 'Aortic Valve',
        'AORTA': 'Aorta',
        'RIGHT_VENTRICLE': 'Right Ventricle / Pulmonary Artery',
        'RIGHT_ATRIUM': 'Right Atrium',
        'PULMONIC_VALVE': 'Pulmonic Valve',
        'TRICUSPID': 'Tricuspid',
        'PERICARDIUM': 'Pericardium',
        'CONCLUSION': 'Conclusion',
      },

      remarkToAdd: {
        echoRemark: null,
        type: "LEFT_VENTRICLE"
      },

      addModalVisible: false,

      commonEchoRemarkToAdd: {
        remark: '',
        type: 'LEFT_VENTRICLE'
      }

    }
  },

  computed: {

    allEchoRemarks: function () { return this.$store.getters.getEchoRemarks },
    visitEchoRemarks: function () { return this.$store.getters.getVisitEchoRemarks },
    selectedEchoRemarks: function () { return this.allEchoRemarks[this.remarkToAdd.type] },

    visitId: function () { return this.$store.getters.getVisitId },
    validated: function () { return this.remarkToAdd.echoValue !== null }

  },

  watch: {
    selectedEchoRemarks() {
      this.remarkToAdd.echoValue = null
    }
  },
  /* *** WATCH *** */

  mounted() {

    this.$store.dispatch('FETCH_ALL_ECHO_REMARKS').then()

    this.$store.dispatch('FETCH_VISIT_ECHO_REMARKS', this.visitId).then()

  },
  /* *** MOUNTED *** */

  methods: {

    onAdd: function () {

      let item = {
        visit_id: this.visitId,
        echo_value_id: this.remarkToAdd.echoValue.id,
        type: this.remarkToAdd.type,
      }

      this.$store.dispatch('ADD_VISIT_ECHO_REMARK', item)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_REMARKS', this.visitId)
                .then()
          })
    },


    onDelete: function (item) {

      this.$store.dispatch('DELETE_VISIT_ECHO_REMARK', item.id)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_REMARKS', this.visitId)
                .then()
          })

    },

    onSaveNewEchoValue: function () {

      let item = {
        value: this.commonEchoRemarkToAdd.value,
        type: this.commonEchoRemarkToAdd.type
      }

      this.$store.dispatch('SAVE_NEW_ECHO_REMARK', item)
          .then(() => {

            this.commonEchoRemarkToAdd.value = ''

            this.addModalVisible = false

          })

    },


  },
}
</script>

<style>


</style>
