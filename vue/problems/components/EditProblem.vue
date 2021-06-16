<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Edit Problem</div>
    <div class="card-body">

      <div class="">


        <div class="form-group">
          <label for="text-remarks">Problem</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model.trim="selectedProblem.problem"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" @click="onUpdate()" :disabled="!isFormValid">Update</button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../_common/bootbox_dialogs";

const _ = require("lodash");

export default {
  name: "EditProblem",

  computed: {
    selectedProblem() {
      return _.cloneDeep(this.$store.getters.getSelectedProblem);
    },

    isFormValid() {
      return this.selectedProblem.problem !== "";
    }

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

        await this.$store.dispatch("problems_fetch", id);

      } catch (e) {
        errorMessageBox("Failed to load selected problem");
        await this.$router.push("/");
      }
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.selectedProblem.id,
          problem: this.selectedProblem.problem
        };

        await this.$store.dispatch("problem_update", params);
        successMessageBox("Problem updated");

      } catch (e) {
        errorMessageBox("Failed to update problem");
      }

      try {
        await this.$store.dispatch("problems_fetchAll");
      } catch (e) {
        errorMessageBox("Failed to fetch problems");
      }

    }

  },

}
</script>

<style scoped>

</style>
