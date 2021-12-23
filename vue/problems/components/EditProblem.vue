<template>

  <div class="card shadow shadow-sm">
    <div class="card-header d-flex justify-content-between">

      <!-- left -->
      <div>
        {{ selectedProblem.problem }}
      </div>

      <!-- right -->
      <div>
        <div v-if="confirmDelete">
          <button class="btn btn-tiny btn-danger" @click="onDelete()">Confirm</button>
          <button class="btn btn-tiny btn-secondary" @click="confirmDelete=false">Cancel</button>
        </div>

        <div v-else>
          <button class="btn btn-tiny btn-outline-danger" @click="confirmDelete=true">
            <img src="/assets/images/actions/remove.svg" class="icon-16" alt=""> Delete
          </button>
        </div>
      </div>

    </div>
    <div class="card-body">

      <div class="">


        <div class="form-group">
          <label for="text-remarks">Problem</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model.trim="selectedProblem.problem"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" @click="onUpdate()" :disabled="!isFormValid">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
          </button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox, successMessageBox} from '@/_common/bootbox_dialogs';

const _ = require('lodash');

export default {
  name: 'EditProblem',

  data() {
    return {
      /* editable form */
      editable: false,

      /* delete confirm */
      confirmDelete: false,

    };
  },

  computed: {
    selectedProblem() {
      return _.cloneDeep(this.$store.getters.getSelectedProblem);
    },

    isFormValid() {
      return this.selectedProblem.problem !== '';
    },

    editButtonText: function () {
      return this.editable ? 'Cancel' : 'Edit';
    },

  },

  async mounted() {

    const id = this.$route.params.id;
    await this.fetchSelected(id);

  },

  async beforeRouteUpdate(to, from, next) {

    const id = to.params.id;
    await this.fetchSelected(id);
    await next();

  },

  methods: {

    async fetchSelected(id) {
      try {

        await this.$store.dispatch('problems_fetch', id);

      } catch (e) {
        errorMessageBox('Failed to load selected problem');
        await this.$router.push('/');
      }
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.selectedProblem.id,
          problem: this.selectedProblem.problem,
        };

        await this.$store.dispatch('problem_update', params);

      } catch (e) {
        errorMessageBox('Failed to update problem');
      }

      try {
        await this.$store.dispatch('problems_fetchAll');
      } catch (e) {
        errorMessageBox('Failed to fetch problems');
      }

    },

    async onDelete() {

      try {

        await this.$store.dispatch('problem_delete', this.selectedProblem.id);

        await this.$store.dispatch('problems_fetchAll');

        this.editable = false;

        successMessageBox('Problem deleted');

        await this.$router.push('/');

      } catch (e) {
        errorMessageBox('Failed to delete the investigation');
      }

    },


  },

};
</script>

<style scoped>

</style>
