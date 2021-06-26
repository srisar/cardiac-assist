<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Investigations
      </div><!-- card-header -->

      <div class="card-body">

        <div class="mb-3">
          <button class="btn btn-sm btn-outline-primary" @click="modalAddVisible = true">
            <img src="/assets/images/actions/add.svg" alt="" class="icon-16"> Add new
          </button>
        </div>


        <!-- investigations list -->
        <div id="visit-investigations-list" class="">

          <table class="table table-bordered table-hover table-sm" v-if="!isEmptyInvestigationsList">

            <tbody>
            <tr v-for="item in visitInvestigationsList">

              <td>
                <p class="font-weight-bold">
                  <a :href="'/app/investigations/manage.php#/edit/' + item.investigation.id" target="_blank">{{ item.investigation.investigation_name }}</a>
                </p>
                <div style="white-space: pre-line">{{ item.remarks }}</div>

                <div class="my-2 text-right">
                  <button class="btn btn-tiny btn-outline-dark" @click="onShowEditModal(item)">
                    <img src="/assets/images/actions/edit.svg" class="icon-16" alt="">
                  </button>

                  <button class="btn btn-tiny btn-outline-danger" @click="onShowDeleteConfirmModal(item)">
                    <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                  </button>
                </div>

              </td>

            </tr>
            </tbody>
          </table>

          <div v-else>
            <p>No items. Start adding investigations.</p>
          </div>

        </div><!-- investigations list -->

      </div><!-- card-body -->
    </div><!-- card -->


    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <!--
    modal: add visit investigations
    -->
    <ModalWindow id="modal-add-visit-investigation" :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add common investigations</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row">
          <div class="col">

            <div class="form-group">
              <select class="form-control" v-model="investigationToAdd.investigation_id">
                <option value="-1" disabled>SELECT ONE</option>
                <option v-for="item in investigationsList" :value="item.id">
                  {{ item.investigation_name }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="investigationToAdd.remarks"></textarea>
            </div>


          </div><!-- col -->
        </div><!-- row -->
        <!-- section: add symptom -->

        <div class="row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onAdd()">Add</button>
          </div>
        </div>

      </slot>
    </ModalWindow>
    <!--
     end: modal: add visit investigation
     -->

    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <!--
     modal: edit visit investigation
     -->
    <ModalWindow id="modal-edit-investigation" :visible="modalEditVisible" @close="modalEditVisible = false">
      <template v-slot:title>Add common investigations</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row">
          <div class="col">

            <div class="form-group">
              <label>Investigation</label>
              <select class="custom-select" v-model.number="investigationToEdit.investigation_id">
                <option v-for="item in investigationsList" :value="item.id">{{ item.investigation_name }}</option>
              </select>
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="5" class="form-control" v-model="investigationToEdit.remarks"></textarea>
            </div>


          </div><!-- col -->
        </div><!-- row -->
        <!-- section: add symptom -->


        <div class="text-center">
          <button class="btn btn-success" @click="onUpdate()">Update</button>
        </div>

      </slot>
    </ModalWindow>
    <!--
     end: modal: visit investigation
     -->


    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <!--
    modal: delete confirm
    -->
    <ModalWindow :visible="modalDeleteVisible" @close="modalDeleteVisible = false">
      <template v-slot:title>Confirm Removal</template>
      <slot>

        <p class="lead text-center">Confirm removing the following added investigation</p>
        <p class="text-center">{{ investigationToEdit.investigation.investigation_name }}</p>

        <div class="text-center">
          <button class="btn btn-danger" @click="onDelete()">Remove</button>
        </div>

      </slot>
    </ModalWindow>
    <!--
    end: modal: delete confirm
    -->


  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../../_common/components/ModalWindow";
import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

const _ = require( "lodash" );

export default {
  name: "VisitInvestigations",
  components: { ModalWindow, RichEditorV2 },

  /*
  * DATA
  * */
  data() {
    return {
      modalAddVisible: false,
      modalEditVisible: false,

      modalDeleteVisible: false,


      investigationToAdd: {
        investigation_id: -1,
        remarks: ""
      },

      investigationToEdit: {
        id: undefined,
        investigation: {},
        investigation_id: -1,
        remarks: "",
      }

    }
  },

  /*
  * COMPUTED
  * */
  computed: {

    visitId() {
      return this.$store.getters.getVisitId;
    },

    visitInvestigationsList: function () {
      return this.$store.getters.getVisitInvestigationsList;
    },

    investigationsList() {
      return this.$store.getters.getInvestigationsList;
    },

    isEmptyInvestigationsList() {
      return _.isEmpty( this.visitInvestigationsList );
    },


  },

  /*
  * MOUNTED
  * */
  async mounted() {

    try {

      /*
       * Fetch investigations for the dropdown
       * */
      await this.$store.dispatch( "investigations_fetchAllAvailableInvestigation" );

    } catch ( e ) {
      errorMessageBox( "Failed to fetch visit investigations" );
    }

    try {
      await this.$store.dispatch( "visitInvestigations_fetchAll", this.visitId );
    } catch ( e ) {
      errorMessageBox( "Failed to fetch visit investigation details" );
    }

  },

  /*
  * METHODS
  * */
  methods: {

    /*
    * On add
    * */
    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          investigation_id: this.investigationToAdd.investigation_id,
          remarks: this.investigationToAdd.remarks
        }

        await this.$store.dispatch( "visitInvestigations_add", params );

        await this.$store.dispatch( "visitInvestigations_fetchAll", this.visitId );

        this.modalAddVisible = false;


      } catch ( e ) {
        errorMessageBox( "Failed to add investigation" );
      }

    },


    /*
    * On show edit modal
    * */
    onShowEditModal( item ) {

      this.investigationToEdit = _.cloneDeep( item );
      this.modalEditVisible = true;

    },

    /*
    * On show delete confirm modal
    * */
    showDeleteConfirmModal( item ) {

      this.investigationToEdit = item;
      this.modalDeleteVisible = true;

    },


    async onUpdate() {

      try {

        const params = {
          id: this.investigationToEdit.id,
          investigation_id: this.investigationToEdit.investigation_id,
          remarks: this.investigationToEdit.remarks
        };

        await this.$store.dispatch( "visitInvestigations_update", params );
        this.modalEditVisible = false;
        successMessageBox( "Investigation details updated" );

        await this.$store.dispatch( "visitInvestigations_fetchAll", this.visitId );

      } catch ( e ) {
        errorMessageBox( "Failed to update investigation details" );
      }

    },

    /*
    * On delete
    * */
    async onDelete() {

      try {

        await this.$store.dispatch( "visitInvestigations_delete", this.investigationToEdit.id );
        await this.$store.dispatch( "visitInvestigations_fetchAll", this.visitId );

        this.modalDeleteVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to remove selected investigation" );
      }

    }

  },

}
</script>

<style scoped>

</style>
