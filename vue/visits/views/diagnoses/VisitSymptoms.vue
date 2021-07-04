<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Clinical Details (Symptoms)</div>


      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">

        <div class="mb-3">
          <button class="btn btn-sm btn-outline-success" @click="modalAddVisible = true">
            <img src="/assets/images/actions/add.svg" alt="" class="icon-16"> Add
          </button>
        </div>

        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">
          <thead>
          <tr>
            <th>Symptom</th>
            <th style="width: 50px" class="text-center">Duration</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in visitSymptomsList" @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">
            <td class="position-relative align-middle">
              <a :href="'/app/symptoms/manage.php#/edit/' + item.symptom.id" target="_blank">{{ item.symptom.symptom_name }}</a>

              <div class="position-absolute hover-group rounded">
                <button class="btn btn-tiny btn-outline-danger" v-show="hoverItemId === item.id" @click="onShowDeleteModal(item)">
                  <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                </button>
              </div>

            </td>
            <td class="text-center">{{ item.duration }}</td>

          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding some symptoms.</p>
        </div>

      </div><!-- card-body -->

      <div v-else class="card-body">
        <TheLoading/>
      </div>

    </div><!-- card -->


    <ModalWindow id="modal-add-visit-symptom" :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add a symptom to clinical details</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row text-center justify-content-center">
          <div class="col">

            <div class="form-group">
              <label>Symptom</label>
              <select class="custom-select" v-model="symptomToAdd.selectedSymptom">
                <option value="-1" disabled>CHOOSE ONE</option>
                <option v-for="item in symptomsList" :value="item">{{ item.symptom_name }}</option>
              </select>
            </div>

          </div><!-- col -->

          <div class="w-100"></div>

          <div class="col-2">
            <div class="form-group">
              <label>Duration</label>
              <input type="text" class="form-control" v-model="symptomToAdd.duration">
            </div>
          </div>

        </div><!-- row -->

        <div class="form-row text-center">
          <div class="col">
            <button class="btn btn-success" @click="onSave()">Add</button>
          </div>
        </div>


        <div class="row">

        </div><!-- row -->

        <!-- section: add symptom -->

      </slot>
    </ModalWindow>


    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <!--
    modal: delete confirm
    -->
    <ModalWindow :visible="modalDeleteVisible" @close="modalDeleteVisible = false">
      <template v-slot:title>Confirm Removal</template>
      <slot>

        <p class="lead text-center">Confirm removing the following clinical detail</p>
        <p class="text-center">{{ symptomToDelete.symptom.symptom_name }} for {{ symptomToDelete.duration }}</p>

        <div class="text-center">
          <button class="btn btn-danger" @click="onDelete()">Remove</button>
        </div>

      </slot>
    </ModalWindow>
    <!--
    end: modal: delete confirm
    -->


  </div><!-- Template -->

</template>

<script>

import ModalWindow from "../../../_common/components/ModalWindow";
import {errorMessageBox} from "../../../_common/bootbox_dialogs";
import TheLoading from "../../../_common/components/TheLoading";


const _ = require( 'lodash' );

export default {
  name: "VisitSymptoms",
  components: { TheLoading, ModalWindow },

  /*
  *
  * DATA
  * */
  data() {
    return {

      loaded: false,

      modalAddVisible: false,
      modalDeleteVisible: false,

      /* symptom duration*/
      symptomDuration: "1/",

      symptomToAdd: {
        selectedSymptom: "-1",
        duration: "1 days"
      },

      symptomToDelete: {
        id: undefined,
        duration: "",
        symptom: {}
      },

      hoverItemId: null,

    }
  },


  computed: {
    visitSymptomsList: function () {
      return this.$store.getters.getVisitSymptomsList;
    },

    symptomsList: function () {
      return this.$store.getters.getSymptomsList;
    },

    isEmpty: function () {
      return this.visitSymptomsList.length === 0;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    }

  },


  async mounted() {

    try {

      await this.$store.dispatch( "visitSymptoms_fetchAll", this.visitId );
      await this.$store.dispatch( "visitSymptoms_fetchAllSymptoms" );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch clinical details" );
    }

  },


  methods: {

    /* On save */
    async onSave() {

      try {

        const params = {
          visit_id: this.visitId,
          symptom_id: this.symptomToAdd.selectedSymptom.id,
          duration: this.symptomToAdd.duration
        };

        await this.$store.dispatch( "visitSymptoms_add", params );
        this.modalAddVisible = false;

        await this.$store.dispatch( "visitSymptoms_fetchAll", this.visitId );


      } catch ( e ) {
        errorMessageBox( "Failed to add clinical detail" );
      }

    },


    async onDelete() {

      try {

        await this.$store.dispatch( "visitSymptoms_delete", this.symptomToDelete.id );
        this.modalDeleteVisible = false;

        await this.$store.dispatch( "visitSymptoms_fetchAll", this.visitId );

      } catch ( e ) {
        errorMessageBox( "Failed to delete clinical detail" );
      }

    },

    onShowDeleteModal( item ) {
      this.symptomToDelete = item;
      this.modalDeleteVisible = true;

    }

  },

}
</script>

<style scoped>

.hover-group {
  top: 5px;
}

</style>
