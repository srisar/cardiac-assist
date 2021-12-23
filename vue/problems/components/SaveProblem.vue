<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Add a problem</div>
    <div class="card-body">

      <div class="">

        <div class="form-group">
          <label for="text-remarks">Problem</label>
          <textarea rows="3" id="text-remarks" class="form-control" v-model.trim="problem.problem"></textarea>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" :disabled="!isFormValid" @click="onSave()">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save
          </button>
        </div>

      </div>

    </div>
  </div>


</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs';

export default {
  name: "SaveProblem",

  data() {

    return {
      problem: {
        problem: "",
      }
    };

  },

  computed: {

    isFormValid() {
      return this.problem.problem !== "";
    }

  },


  methods: {

    async onSave() {

      try {

        const params = {
          problem: this.problem.problem,
        };

        await this.$store.dispatch("problem_save", params);

      } catch (e) {
        errorMessageBox("Failed to save");
      }

      try {
        await this.$store.dispatch("problems_fetchAll");
      } catch (e) {
        errorMessageBox("Failed to fetch problems");
      }

    }, /* on save */

  }

}
</script>

<style scoped>

</style>
