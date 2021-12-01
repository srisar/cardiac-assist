<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <div>Problems List</div>
      </div><!-- card-header -->

      <div class="card-body" v-if="loaded">

        <div class="mb-3">
          <button class="btn btn-sm btn-outline-success" @click="modalAddVisible = true">
            <img src="/assets/images/actions/add.svg" alt="" class="icon-16"> Add
          </button>
        </div>


        <table class="table table-sm table-hover table-bordered" v-if="!isEmpty">

          <tbody>
          <tr v-for="item in visitProblemsList" @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">
            <td class="position-relative">
              <a :href="'/app/problems/manage.php#/edit/' + item.problem.id" target="_blank">{{ item.problem.problem }}</a>
              <span> - </span>
              <span>{{ item.remarks }}</span>
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

    <ModalWindow id="modal-add-visit-symptom" :visible="modalAddVisible" @close="modalAddVisible = false; showSaveNewProblemSection = false">
      <template v-slot:title>Add a problem</template>
      <slot>

        <!-- section : add symptom -->
        <div class="row text-center justify-content-center">
          <div class="col">

            <div class="form-group">
              <label>Choose a problem from the list</label>
              <select class="custom-select" v-model="problemToAdd.problem">
                <option :value="null" disabled>CHOOSE ONE</option>
                <option v-for="item in problems" :value="item">{{ item.problem }}</option>
              </select>
            </div>

          </div><!-- col -->
        </div><!-- row -->

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>Remarks</label>
              <input type="text" class="form-control" v-model.trim="problemToAdd.remarks">
            </div>
          </div>
        </div>

        <div class="form-row text-center">
          <div class="col">
            <button class="btn btn-success" @click="onAdd()">Add</button>
          </div>
        </div>

        <button class="btn btn-link" @click="showSaveNewProblemSection = !showSaveNewProblemSection">Create a new problem</button>

        <div class="row mt-3" v-if="showSaveNewProblemSection">

          <div class="col">

            <hr>

            <div class="mb-3">
              <label>Problem</label>
              <textarea class="form-control" v-model.trim="newProblemToSave"></textarea>
            </div>

            <div class="text-center">
              <button class="btn btn-primary btn-sm" @click="onSaveNewProblem()">Save a new problem</button>
            </div>

          </div>

        </div><!-- row -->

        <!-- section: add symptom -->

      </slot>
    </ModalWindow>

  </div><!-- Template -->

</template>

<script>
import voca from 'voca';
import {errorMessageBox, successMessageBox} from '../../../_common/bootbox_dialogs';
import ModalWindow from '../../../_common/components/ModalWindow';
import TheLoading from '../../../_common/components/TheLoading';

export default {
  name: 'VisitProblems',
  components: { TheLoading, ModalWindow },

  data() {
    return {

      loaded: false,

      modalAddVisible: false,
      modalDeleteVisible: false,

      showSaveNewProblemSection: false,

      problemToAdd: {
        problem: null,
        remarks: '',
      },

      problemToDelete: {
        id: undefined,
        problem: '',
      },

      newProblemToSave: '',

      hoverItemId: null,

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


    onShowDeleteModal( item ) {
      this.symptomToDelete = item;
      this.modalDeleteVisible = true;

    }, /* show delete modal */

    async onSaveNewProblem() {

      try {

        const params = {
          problem: this.newProblemToSave,
        };

        await this.$store.dispatch( 'visitProblems_saveProblem', params );

        successMessageBox( 'New problem saved, please choose it from the list now.' );

        this.newProblemToSave = '';

      } catch ( e ) {
        errorMessageBox( 'Failed to save new problem' );
      }

      try {
        await this.$store.dispatch( 'visitProblems_fetchAllProblems' );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch problems list' );
      }

    }, /* on save new problem */


  },


};
</script>

<style scoped>

.hover-group {
  top: 5px;
}

</style>
