<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Problems List</div>
      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">

        <div class="row no-gutters">
          <div class="col">
            <AutoCompleteTextBox
                search-dispatch-name="visitProblems_search"
                add-dispatch-name="visitProblems_addProblem"
                field-name="problem"
                v-model="problemToAdd.problem"
                @input="onAdd"
            />
          </div>
        </div>

        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">

          <tbody>
          <tr v-for="item in visitProblemsList" @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">
            <td class="position-relative">

              <p class="font-weight-bold mb-1">
                <a :href="'/app/problems/manage.php#/edit/' + item.problem.id" target="_blank">{{ item.problem.problem }}</a>
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

    <!-- ------------------------------------------------------------------------------------------------------------------------------------- -->


  </div><!-- Template -->

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';

import _ from 'lodash';
import voca from 'voca';
import ModalWindow from '../../../_common/components/ModalWindow';
import TheLoading from '../../../_common/components/TheLoading';

export default {
  name: 'VisitProblems',
  components: { AutoCompleteTextBox, TheLoading, ModalWindow },

  data() {
    return {

      loaded: false,

      problemToAdd: {
        problem: null,
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

  computed: {
    visitProblemsList() {
      return this.$store.getters.getVisitProblemsList;
    },

    problems() {
      return this.$store.getters.getProblems;
    },

    isEmpty: function () {
      return this.visitProblemsList.length === 0;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

  },


  async mounted() {

    try {

      await this.$store.dispatch( 'visitProblems_fetchAll', this.visitId );
      await this.$store.dispatch( 'visitProblems_fetchAllProblems' );

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch visit problems' );
    }

  },


  methods: {

    /* On add */
    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          problem_id: this.problemToAdd.problem.id,
          remarks: voca.capitalize( this.problemToAdd.remarks ),
        };

        await this.$store.dispatch( 'visitProblems_add', params );
        this.modalAddVisible = false;

      } catch ( e ) {
        errorMessageBox( 'Failed to add clinical detail' );
      }

      try {
        await this.$store.dispatch( 'visitProblems_fetchAll', this.visitId );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch visit problems' );
      }

    }, /* on add */


    async onDelete( item ) {

      try {

        await this.$store.dispatch( 'visitProblems_delete', item.id );
        this.modalDeleteVisible = false;

        await this.$store.dispatch( 'visitProblems_fetchAll', this.visitId );

      } catch ( e ) {
        errorMessageBox( 'Failed to delete visit problem' );
      }
    }, /* on delete */



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

        await this.$store.dispatch( 'visitProblems_update', params );

        await this.$store.dispatch( 'visitProblems_fetchAll', this.visitId );

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

.hover-group {
  top: 5px;
}


</style>
