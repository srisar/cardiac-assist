<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Edit {{ selectedLetter.title }}</div>
    <div class="card-body">

      <div class="">
        <div class="form-group">
          <label>Title</label>
          <input type="text" class="form-control" v-model="selectedLetter.title">
        </div>

        <div class="form-group">
          <label>Letter Model</label>
          <RichEditorV2 v-model="selectedLetter.letter_model"></RichEditorV2>
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
import {errorMessageBox, successMessageBox} from "../../_common/bootbox_dialogs";
import RichEditorV2 from "../../_common/components/RichEditorV2";

const _ = require("lodash");

export default {
  name: "EditLetters",
  components: {RichEditorV2},
  data() {
    return {

      selectedLetter: {},

    }
  },

  computed: {

    isFormValid() {
      return this.selectedLetter.title !== "";
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

        await this.$store.dispatch("letters_fetch", id);
        this.selectedLetter = _.cloneDeep(this.$store.getters.getSelectedLetter);

      } catch (e) {
        errorMessageBox("Failed to load selected letter data");
        await this.$router.push("/");
      }
    },

    /*
    * On update
    * */
    async onUpdate() {

      try {

        const params = {
          id: this.selectedLetter.id,
          title: this.selectedLetter.title,
          letter_model: this.selectedLetter.letter_model,
        };

        await this.$store.dispatch("letters_update", params);

        successMessageBox("Letter details updated");

      } catch (e) {
        errorMessageBox("Failed to update letter details");
      }

      try {
        await this.$store.dispatch("letters_fetchAll");
      } catch (e) {
        errorMessageBox("Failed to fetch letter details");
      }

    }

  },
}
</script>

<style scoped>

</style>
