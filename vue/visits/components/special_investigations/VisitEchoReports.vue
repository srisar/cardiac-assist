<template>

  <div>


    <hr>
    <h5 class="text-center font-weight-bold text-uppercase">Remarks</h5>

    <div class="card mb-3" v-for="(item, key) in echoRemarksTypes">
      <div class="card-header d-flex justify-content-between">

        <div>{{ item }}</div>

      </div>
      <div class="card-body">

        <div class="mb-3">
          <div class="input-group input-group-sm">

            <select class="custom-select" v-model="selectedRemarks[key]">
              <option v-for="(item, key) in allEchoRemarks[key]" :value="key">{{ item.value }}</option>
            </select>

            <div class="input-group-append">
              <button class="btn btn-primary" @click="onInsert(key)" :disabled="hasRemarks(key)">Insert</button>
              <button class="btn btn-success" @click="onOpenAddModal(key)">Add</button>
            </div>
          </div>
        </div>


        <table class="table table-bordered table-sm table-hover">
          <tbody>
          <tr v-for="item in visitEchoRemarks[key]">
            <td style="white-space: pre-line">{{ item.value }}</td>
            <td style="width: 30px">
              <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
            </td>
          </tr>
          </tbody>
        </table>


      </div>
    </div>


    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <ModalWindow :visible="modalAddVisible" @close="modalAddVisible = false">
      <slot>

        <div class="form-group">
          <label>Type</label>
          <input type="text" class="form-control" readonly v-model="echoRemarkToAdd.typeLabel">
        </div>

        <div class="form-group">
          <label>Value</label>
          <textarea class="form-control" rows="3" v-model.trim="echoRemarkToAdd.value"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAdd()" :disabled="echoRemarkToAdd.value === ''">Add</button>
        </div>

      </slot>
    </ModalWindow>


  </div><!-- template -->

</template>

<script>


import ModalWindow from "../../../_common/components/ModalWindow";
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitEchoReports",
  components: {ModalWindow},

  data() {
    return {

      /* modal */
      modalAddVisible: false,

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

      selectedRemarks: {
        'LEFT_VENTRICLE': 0,
        'LEFT_ATRIUM': 0,
        'MITRAL_VALVE': 0,
        'AORTIC_VALVE': 0,
        'AORTA': 0,
        'RIGHT_VENTRICLE': 0,
        'RIGHT_ATRIUM': 0,
        'PULMONIC_VALVE': 0,
        'TRICUSPID': 0,
        'PERICARDIUM': 0,
        'CONCLUSION': 0,
      },


      echoRemarkToAdd: {
        value: "",
        type: "",
        typeLabel: "",
      }

    }
  },

  computed: {

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks
    },


    visitId: function () {
      return this.$store.getters.getVisitId
    },


  },


  async mounted() {

    try {

      await this.$store.dispatch("echo_fetchAllRemarks");
      await this.$store.dispatch("echo_fetchAllVisitRemarks", this.visitId);

    } catch (e) {
      errorMessageBox("Failed to fetch remarks");
    }


  },
  /* *** MOUNTED *** */

  methods: {

    async onInsert(group) {

      try {

        const index = this.selectedRemarks[group];
        const item = this.allEchoRemarks[group][index];

        const params = {
          visit_id: this.visitId,
          echo_value_id: item.id,
        }

        await this.$store.dispatch("echo_addVisitRemark", params);


      } catch (e) {
        errorMessageBox("Failed to insert");
      }

      try {
        await this.$store.dispatch("echo_fetchAllVisitRemarks", this.visitId);
      } catch (e) {
        errorMessageBox("Failed to fetch remarks");
      }


    },

    async onAdd() {

      try {

        const params = {
          type: this.echoRemarkToAdd.type,
          value: this.echoRemarkToAdd.value,
        };

        await this.$store.dispatch("echo_addEchoRemark", params);
        await this.$store.dispatch("echo_fetchAllRemarks");

        this.modalAddVisible = false;

      } catch (e) {
        errorMessageBox("Failed to add new echo remark item");
      }

    },

    async onDelete(item) {

      try {

        await this.$store.dispatch("echo_delete", item.id);

      } catch (e) {
        errorMessageBox("Failed to delete selected remark item");
      }

      try {
        await this.$store.dispatch("echo_fetchAllVisitRemarks", this.visitId);
      } catch (e) {
        errorMessageBox("Failed to fetch remarks");
      }

    },

    /*
    * On opening add modal
    * */
    onOpenAddModal(type) {
      this.echoRemarkToAdd.type = type;
      this.echoRemarkToAdd.typeLabel = this.echoRemarksTypes[type];
      this.modalAddVisible = true;
    },


    /*
    * check if theres items in the echo remarks
    * */
    hasRemarks(group) {
      return !!_.isEmpty(this.allEchoRemarks[group]);
    }


  },
}
</script>

<style>


</style>
