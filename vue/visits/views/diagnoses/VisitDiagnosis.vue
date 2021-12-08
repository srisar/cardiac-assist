<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Diagnoses</div>
      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">

        <div class="row no-gutters">
          <div class="col">
            <AutoCompleteTextBox
								place-holder-text="Search and add diagnoses..."
                search-dispatch-name="diffDiagnoses_searchDiseases"
                add-dispatch-name="diffDiagnoses_addDisease"
                field-name="disease"
                v-model="visitDiagnosisToAdd.disease"
                @input="onAdd"
            />
          </div>
        </div>


        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">

          <tbody>
          <tr v-for="item in visitDiagnosisList" :key="item.id"
              @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">

            <td class="position-relative">
              <p class="font-weight-bold mb-1">
                <a href="#">{{ item.disease.disease }}</a> ({{ item.disease.disease_code }})
              </p>

              <!-- remarks show and edit -->
              <div class="" v-if="showEditRemarks && selectedItemId === item.id">
                <input type="text"
                       class="form-control"
                       :id="'txt_remarks'+item.id"
                       v-model="selectedItem.remarks"
                       @blur="onUpdateRemarks"
                       @keyup.enter="onUpdateRemarks">
              </div>
              <div class="" v-else>

                <div class="pointer" style="white-space: pre-line" v-if="item.remarks" @click="onSelectRemarkToEdit(item)">{{ item.remarks }}</div>
                <div class="text-secondary pointer" v-else @click="onSelectRemarkToEdit(item)">
                  Click here to add remarks (Enter to save)
                </div>
              </div>
              <!-- remarks show and edit -->


              <div class="position-absolute rounded hover-group">
                <button class="btn btn-tiny btn-outline-danger" v-show="hoverItemId === item.id" @click="onDelete(item)">
                  <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                </button>
              </div>

            </td>

          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding something.</p>
        </div>

      </div><!-- card-body -->
      <div class="card-body" v-else>
        <TheLoading/>
      </div>

    </div><!-- card -->


  </div>

</template>

<script>

import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import voca from 'voca';
import ModalWindow from '../../../_common/components/ModalWindow';
import TheLoading from '../../../_common/components/TheLoading';

const _ = require( 'lodash' );

export default {
  name: 'VisitDiagnosis',
  components: { AutoCompleteTextBox, TheLoading, ModalWindow },

  data() {
    return {

      loaded: false,

      /* modal hooks */
      modalAddVisible: false,
      modalEditVisible: false,
      modalDeleteVisible: false,


      visitDiagnosisToAdd: {
        disease: null,
        remarks: '',
      },

      visitDiagnosisToEdit: {
        disease: {},
        remarks: '',
      },

      hoverItemId: null,


      /* edit remarks */
      showEditRemarks: false,
      selectedItemId: null,
      selectedItem: {
        item: null,
        remarks: '',
      },


    };
  },
  /* *** DATA *** */


  computed: {
    visitDiagnosisList: function () {
      return this.$store.getters.getVisitDiagnosisList;
    },

    diseasesList: function () {
      return this.$store.getters.getDiseasesList;
    },

    isEmpty: function () {
      return this.visitDiagnosisList.length === 0;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },


  },
  /* *** COMPUTED *** */


  async mounted() {

    try {

      await this.$store.dispatch( 'diffDiagnoses_fetchAllDiseases' );
      await this.$store.dispatch( 'diagnoses_fetchAll', this.visitId );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to load diagnoses' );
    }

  },
  /* *** MOUNTED *** */


  methods: {

    async fetchAllVisitDiagnoses() {
      try {
        await this.$store.dispatch( 'diagnoses_fetchAll', this.visitId );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch diagnoses' );
      }

    },


    /* On add */
    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          disease_id: this.visitDiagnosisToAdd.disease.id,
          remarks: this.visitDiagnosisToAdd.remarks,
        };

        await this.$store.dispatch( 'diagnoses_add', params );
        this.modalAddVisible = false;

      } catch ( e ) {
        errorMessageBox( 'Failed to add diagnosis details' );
      }

      await this.fetchAllVisitDiagnoses();


    },


    /* On delete */
    async onDelete( item ) {

      try {

        await this.$store.dispatch( 'diagnoses_delete', item.id );

      } catch ( e ) {
        errorMessageBox( 'Failed to delete diagnosis' );
      }

      await this.fetchAllVisitDiagnoses();

    },


    /*
    * ------------------------------------------------------------
    * Selected item's edit remarks logic
    * ------------------------------------------------------------
    * */

    onSelectRemarkToEdit( problem ) {
      this.selectedItem = _.cloneDeep( problem );

      this.selectedItemId = problem.id;
      this.showEditRemarks = true;

      this.$nextTick( () => {
        /* set focus on the selected text box */
        document.getElementById( 'txt_remarks' + problem.id ).focus();
      } );

    }, /* onSelectRemarkToEdit */

    async onUpdateRemarks() {

      /*
       * if selectedProblem is null, then dont do anything
       * this is needed because we are hooking both blur and enter events
       * to the same function. once enter is pressed, this code will run
       * and then set selectedProblem = null, this will cause an issue
       * when blur is trying to run.
       * */
      if ( _.isNull( this.selectedItem ) ) return false;

      try {

        const params = {
          id: this.selectedItemId,
          remarks: voca.capitalize( this.selectedItem.remarks ),
        };

        await this.$store.dispatch( 'diagnoses_update', params );

        await this.$store.dispatch( 'diagnoses_fetchAll', this.visitId );

      } catch ( e ) {
        console.log( e );
        errorMessageBox( 'Failed to update' );
      }


      this.$nextTick( () => {
        this._resetSelectedProblem();
      } );

    },


    _resetSelectedProblem() {
      this.selectedItem = null;
      this.selectedItemId = null;
      this.showEditRemarks = false;
    },


  },

};
</script>

<style scoped>

</style>
