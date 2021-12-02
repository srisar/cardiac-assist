<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Clinical Details (Symptoms)</div>


      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">


        <div class="row no-gutters">
          <div class="col">
            <AutoCompleteTextBox
                search-dispatch-name="visitSymptoms_search"
                add-dispatch-name="visitSymptoms_addSymptom"
                field-name="symptom_name"
                v-model="symptomToAdd.selectedSymptom"
                @input="onAdd"
            />
          </div>
        </div>


        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">
          <thead>
          <tr>
            <th>Symptom</th>
            <th style="width: 100px" class="text-center">Duration</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in visitSymptomsList" @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">

            <td class="position-relative align-middle">
              <a :href="'/app/symptoms/manage.php#/edit/' + item.symptom.id" target="_blank">{{ item.symptom.symptom_name }}</a>

              <div class="position-absolute hover-group rounded">
                <button class="btn btn-tiny btn-outline-danger" v-show="hoverItemId === item.id" @click="onDelete(item)">
                  <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                </button>
              </div>

            </td>
            <td class="text-center">
              <!-- remarks show and edit -->
              <div class="" v-if="showEditDuration && selectedItemId === item.id">
                <input type="text"
                       class="form-control"
                       :id="'txt_duration'+item.id"
                       v-model="selectedItem.duration"
                       @blur="onUpdateDuration"
                       @keyup.enter="onUpdateDuration">
              </div>
              <div class="" v-else>

                <div class="pointer" v-if="item.duration" @click="onSelectDurationToEdit(item)">{{ item.duration }}</div>
                <div class="text-secondary pointer" v-else @click="onSelectDurationToEdit(item)">
                  -
                </div>
              </div>
              <!-- remarks show and edit -->

            </td>

          </tr>
          </tbody>
        </table>

        <div v-else>
          <p>No items. Start adding something.</p>
        </div>

      </div><!-- card-body -->

      <div v-else class="card-body">
        <TheLoading/>
      </div>

    </div><!-- card -->

  </div><!-- Template -->

</template>

<script>

import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import voca from 'voca';
import ModalWindow from '../../../_common/components/ModalWindow';
import TheLoading from '../../../_common/components/TheLoading';


const _ = require( 'lodash' );

export default {
  name: 'VisitSymptoms',
  components: { AutoCompleteTextBox, TheLoading, ModalWindow },

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
      symptomDuration: '1/',

      symptomToAdd: {
        selectedSymptom: null,
        duration: '1 days',
      },

      symptomToDelete: {
        id: undefined,
        duration: '',
        symptom: {},
      },

      hoverItemId: null,

      /* edit duration */
      showEditDuration: false,
      selectedItemId: null,
      selectedItem: {
        item: null,
        duration: '',
      },

    };
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
    },

  },


  async mounted() {

    try {

      await this.$store.dispatch( 'visitSymptoms_fetchAll', this.visitId );
      await this.$store.dispatch( 'visitSymptoms_fetchAllSymptoms' );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch clinical details' );
    }

  },


  methods: {

    /* On save */
    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          symptom_id: this.symptomToAdd.selectedSymptom.id,
          duration: this.symptomToAdd.duration,
        };

        await this.$store.dispatch( 'visitSymptoms_add', params );

        await this.$store.dispatch( 'visitSymptoms_fetchAll', this.visitId );

      } catch ( e ) {
        errorMessageBox( 'Failed to add clinical detail' );
      }

    },


    async onDelete( item ) {

      try {

        await this.$store.dispatch( 'visitSymptoms_delete', item.id );
        await this.$store.dispatch( 'visitSymptoms_fetchAll', this.visitId );

      } catch ( e ) {
        errorMessageBox( 'Failed to delete clinical detail' );
      }

    },


    /*
     * ------------------------------------------------------------
     * Selected item's edit remarks logic
     * ------------------------------------------------------------
     * */

    onSelectDurationToEdit( item ) {
      this.selectedItem = _.cloneDeep( item );

      this.selectedItemId = item.id;
      this.showEditDuration = true;

      this.$nextTick( () => {
        /* set focus on the selected text box */
        document.getElementById( 'txt_duration' + item.id ).focus();
      } );

    }, /* --------------------------------------------------------- */

    async onUpdateDuration() {

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
          duration: voca.capitalize( this.selectedItem.duration ),
        };

        await this.$store.dispatch( 'visitSymptoms_update', params );

        await this.$store.dispatch( 'visitSymptoms_fetchAll', this.visitId );

      } catch ( e ) {
        console.log( e );
        errorMessageBox( 'Failed to update' );
      }


      this.$nextTick( () => {
        this._resetSelectedItem();
      } );

    }, /* --------------------------------------------------------- */


    _resetSelectedItem() {
      this.selectedItem = null;
      this.selectedItemId = null;
      this.showEditRemarks = false;

    }, /* --------------------------------------------------------- */

  },

};
</script>

<style scoped>

.hover-group {
  top: 5px;
}

</style>
