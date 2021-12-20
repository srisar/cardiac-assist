<template>

  <div>

    <div class="row">
      <div class="col">

        <div class="card shadow shadow-sm">

          <div class="card-header">Further Investigations</div>

          <div class="card-body">

            <AutoCompleteTextBox
                place-holder-text="Search and add further investigations..."
                search-dispatch-name="visitInvestigations_search"
                add-dispatch-name="furtherInvestigations_addInvestigation"
                field-name="investigation_name"
                v-model="investigationToAdd.investigation"
                @input="onAdd"
            />

            <table class="table table-sm table-bordered table-hover">
              <tbody>
              <tr v-for="item in furtherInvestigationsList" :key="item.id"
                  @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">

                <td class="position-relative">
                  <p class="font-weight-bold">
                    <a :href="'/app/investigations/manage.php#/edit/' + item.investigation.id"
                       target="_blank">{{ item.investigation.investigation_name }}</a>
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

                    <div class="pointer" style="white-space: pre-line" v-if="item.remarks"
                         @click="onSelectRemarkToEdit(item)">
                      <span :class="abnormalRemarks(item.remarks)">{{ item.remarks }}</span>
                    </div>
                    <div class="text-secondary pointer" v-else @click="onSelectRemarkToEdit(item)">
                      Click here to add remarks (Enter to save)
                    </div>
                  </div>
                  <!-- remarks show and edit -->


                  <div class="mt-2 position-absolute hover-group rounded p-1" v-show="hoverItemId === item.id">
                    <button class="btn btn-tiny btn-outline-danger" @click="onDelete(item)">
                      <img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
                    </button>
                  </div>

                </td>
              </tr>
              </tbody>

            </table>

          </div>

        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->

  </div><!-- template -->

</template>

<script>
import {errorMessageBox, successMessageBox} from '../../../_common/bootbox_dialogs';
import ModalWindow from '../../../_common/components/ModalWindow';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox';
import _ from 'lodash';
import voca from 'voca';

export default {
  name: 'FurtherInvestigationsView',
  components: {AutoCompleteTextBox, ModalWindow},
  data() {
    return {

      isEditModalVisible: false,

      isDeleteConfirmModalVisible: false,


      /* all investigations the db */
      investigationsList: [],

      investigationToAdd: {
        investigation: null,
        remarks: ''
      },

      investigationToEdit: {
        id: undefined,
        investigation: {},
        investigation_id: -1,
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

    visitId() {
      return this.$store.getters.getVisitId;
    },

    isAddFormInvalid() {
      return this.investigationToAdd.investigation_id === -1;
    },

    furtherInvestigationsList() {
      return this.$store.getters.getFurtherInvestigationsList;
    }

  },


  filters: {},

  async mounted() {

    try {

      /* 1.fetch all investigations */
      this.$store.dispatch('investigations_fetchAllAvailableInvestigation').then(() => {
        this.investigationsList = this.$store.getters.getInvestigationsList;
      });


      /* 2. fetch all further investigations */
      await this.$store.dispatch('furtherInvestigations_fetchAll', this.visitId);


    } catch (e) {
      errorMessageBox('Failed to load data');
    }

  },

  methods: {

    async onAdd() {

      try {

        const params = {
          visit_id: this.visitId,
          investigation_id: this.investigationToAdd.investigation.id,
          remarks: this.investigationToAdd.remarks
        };

        await this.$store.dispatch('furtherInvestigations_add', params);

        /* fetch added  further investigations */
        await this.$store.dispatch('furtherInvestigations_fetchAll', this.visitId);

      } catch (e) {
        errorMessageBox('Failed to add the investigation');
      }

    },

    /*
    * On update
    * */
    // async onUpdate() {
    //
    //   try {
    //
    //     const params = {
    //       id: this.investigationToEdit.id,
    //       investigation_id: this.investigationToEdit.investigation_id,
    //       remarks: this.investigationToEdit.remarks
    //     };
    //
    //     await this.$store.dispatch('furtherInvestigations_update', params);
    //
    //     this.isEditModalVisible = false;
    //     successMessageBox('Further investigation details updated');
    //
    //     await this.$store.dispatch('furtherInvestigations_fetchAll', this.visitId);
    //
    //   } catch (e) {
    //     errorMessageBox('Failed to update investigation details');
    //   }
    //
    // },


    /*
    * On delete
    * */
    async onDelete(item) {

      try {

        await this.$store.dispatch('furtherInvestigations_delete', item.id);
        await this.$store.dispatch('furtherInvestigations_fetchAll', this.visitId);

      } catch (e) {
        errorMessageBox('Failed to remove selected investigation');
      }
    }, /* onDelete */


    abnormalRemarks(remarks) {
      if (voca.first(remarks) === '*') {
        return 'text-danger font-weight-bold';
      }
      return '';
    },

    /*
	   * ------------------------------------------------------------
	   * Selected item's edit remarks logic
	   * ------------------------------------------------------------
	   * */

    onSelectRemarkToEdit(problem) {
      this.selectedItem = _.cloneDeep(problem);

      this.selectedItemId = problem.id;
      this.showEditRemarks = true;

      this.$nextTick(() => {
        /* set focus on the selected text box */
        document.getElementById('txt_remarks' + problem.id).focus();
      });

    }, /* onSelectRemarkToEdit */

    async onUpdateRemarks() {

      /*
       * if selectedProblem is null, then don't do anything
       * this is needed because we are hooking both blur and enter events
       * to the same function. once enter is pressed, this code will run
       * and then set selectedProblem = null, this will cause an issue
       * when blur is trying to run.
       * */
      if (_.isNull(this.selectedItem)) return false;

      try {

        const params = {
          id: this.selectedItemId,
          remarks: voca.capitalize(this.selectedItem.remarks),
        };

        await this.$store.dispatch('furtherInvestigations_update', params);

        await this.$store.dispatch('furtherInvestigations_fetchAll', this.visitId);

      } catch (e) {
        console.log(e);
        errorMessageBox('Failed to update');
      }


      this.$nextTick(() => {
        this._resetSelectedProblem();
      });

    },


    _resetSelectedProblem() {
      this.selectedItem = null;
      this.selectedItemId = null;
      this.showEditRemarks = false;
    },


  },
  /* METHODS */

};
</script>

<style scoped>

</style>
